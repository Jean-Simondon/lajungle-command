<?php
namespace YOUR_THEME_NAME\Features;

use Illuminate\Support\Facades\Log;
use Iquitheme\Core\Features\FeatureManager;
use Themosis\Facades\View;

class FeatureAccount extends FeatureManager
{

	protected function _initHooks()
	{
		// ne pas enregistrer l'entrée dans GF
        add_action( 'gform_after_submission', [$this, 'afterSubmission'], 10, 2);
		// validation des formulaires => connexion
        add_action( 'gform_validation', [$this, 'customValidation_login'], 10, 2);
        add_action( 'gform_validation', [$this, 'customValidation_modification'], 10, 2);
        add_action( 'gform_validation', [$this, 'customValidation_creation'], 10, 2);
		// confirmation post formulaire valide => redirection post connexion ou post modification
		add_filter( 'gform_confirmation', [$this, 'customConfirmation'], 10, 4 );
        // add_filter( 'gform_pre_render_3', [$this, 'populateFieldData'], 10, 3); // préremplir le formulaire gravityform quand on va sur l'espace pro
        add_action('lostpassword_post', [$this, 'onLostPasswordPost'], 10, 2);  // gestion après reset du mot de passe
        // add_action( 'gform_pre_submission_3', [$this, 'changePassword' ]);

        add_action('after_password_reset', [$this, 'lostPasswordRedirect'], 10, 2);

        // Customisation du mail pour le reset de password
        add_filter('retrieve_password_message', [$this, 'changeRetrievePasswordMessage'], 10, 4);
		add_filter('retrieve_password_title', [$this, 'changeRetrievePasswordTitle'], 10, 3);
        // Customisation du mail selon la situation
        add_action('wp_mail_from', [$this, 'customFromFieldMail'], 10, 1);
        add_action('wp_mail_from_name', [$this, 'customFromNameFieldMail'], 10, 1);
        add_action('wp_mail_content_type', [$this, 'customeContentTypeMail'], 10, 1);

        add_filter( 'init', [$this, 'initViewComposer'] );
        
        // pour filtrer le moment de la validation, par un admin, d'une inscription par un utilisateur
        add_filter( 'gform_activate_user', [$this, 'set_right_role_when_activating_user'], 10, 3 );


        add_action( 'show_user_profile', [$this, 'add_field_to_account_view'], 30 ); // admin: edit profile
		add_action( 'edit_user_profile', [$this, 'add_field_to_account_view'], 30 ); // admin: edit other users
    }

    /**
     * Appliquer la valeur du champ fonction comme rôle de l'utilisateur au moment de la validation de
     * son inscription par l'administrateur dans formulaire -> inscription -> activation en attente
     */
    public function set_right_role_when_activating_user( $user_id, $user_data, $signup_meta )
    {
        $user = get_user_by('ID', $user_id);
        $roleToSet = get_user_meta($user_id, 'fonction');

        // set role pour les utilisateurs par reconnaissance de chaine de caractère depuis le champ meta
        if( stripos($roleToSet[0] ,'influenceur')) {
            $user->set_role('');
            $user->set_role('blogueurinfluenceur');
        } elseif( stripos($roleToSet[0] ,'print')) {
            $user->set_role('');
            $user->set_role('journalisteprint');
        } elseif( stripos($roleToSet[0] ,'web')) {
            $user->set_role('');
            $user->set_role('journalisteweb');
        } elseif( stripos($roleToSet[0] ,'TV')) {
            $user->set_role('');
            $user->set_role('journalistetv');
        } elseif( stripos($roleToSet[0] ,'radio')) {
            $user->set_role('');
            $user->set_role('journalisteradio');
        } elseif( stripos($roleToSet[0] ,'xploit')) {
            $user->set_role('');
            $user->set_role('exploitant');
        }

    }

    /**
     * Gestion post soumission du formulaire, pour supprimer les entrées dans GF par ex.
     */
    public function afterSubmission($entry, $form)
    {
        $disabledEntries = [
            intval(get_field('opt_form_login', 'option')),
            // intval(get_field('opt_form_register', 'option')),
        ];
        if(in_array($form['id'], $disabledEntries)){
            // suppression de l'entrée pour éviter qu'elle ne s'enregistre en base
            \GFAPI::delete_entry( $entry['id'] );
        }
    }

    /**
     * Gestion de la validation des formulaires :
     * - Login : vérification que l'utilisateur est le bon (connexion si oui / message d'erreur sinon). Si la connexion est valide, c'est le filtre de confirmation qui gère la redirection
     */
    public function customValidation_login($validation)
    {
        $form = $validation['form'];
        global $wp;
        if($form['id'] == intval(get_field('opt_form_login', 'option'))) {
            $retour = false;
            if (!is_user_logged_in()) {
                $email = '';
                $password = '';
                if(isset($form['fields']) && is_array($form['fields']) && count($form['fields'])>0){
                    foreach($form['fields'] as $k=>$v){
                        if($v->type == 'email' && isset($_POST['input_'.$v->id])) {
                            $email = $_POST['input_'.$v->id];
                        } elseif ($v->type == 'password' && isset($_POST['input_'.$v->id])){
                            $password = $_POST['input_'.$v->id];
                        }
                    }
                }

                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
                $email = preg_match( $regex, $email ) ? $email :  "invalid email";

                if( $email !== "invalid email" ) {
                    $check = wp_authenticate_email_password( NULL, $email, $password);
                    if(!is_wp_error($check)){
                        $user_id = $check->ID;
                        wp_set_current_user($check->ID, $email);
                        wp_set_auth_cookie($check->ID);
                        do_action('wp_login', $email);
                        $retour = true;
                    }
                }

            }
            if( !$retour ) {
                $validation['is_valid'] = false;
                add_filter( 'gform_validation_message', function ( $message, $form ) {
                    return '<p class="message-error">Le couple email/mot de passe est inconnu ou invalide</p>';
                }, 10, 2);
            }
        }
        return $validation;
    }

    /**
     * Passages des champs importants en lowercase
     */
    public function customValidation_creation($validation)
    {
        $form = $validation['form'];
        global $wp;
        if( $form['id'] == intval(get_field('opt_form_register', 'option'))) {
            foreach($form['fields'] as $k => $v) {
                if($v->type == 'email' && isset($_POST['input_'.$v->id])) { // email
                } elseif($v->type == 'password' && isset($_POST['input_'.$v->id])) { 
                }
            }
        }
        return $validation;
    }


    public function customValidation_modification($validation)
    {
        $form = $validation['form'];
        global $wp;
        // Si on est bien sur le formulaire 'opt_form_modificate' afin de faire un update des données utilisateurs
        if( $form['id'] == intval(get_field('opt_form_modificate', 'option')) ) {
            if ( is_user_logged_in() ) {
                /**
                 * Array de la forme :
                 *  $name['key']; pour trouver son indice dans $form['fields'], et modifier des valeurs tel que failed_validation et validation_message;
                 *  $name['value']; pour récupérer sa valeur;
                 */
                $current_user = wp_get_current_user();
                $email = [];
                $password = [];
                $new_password = [];
                $new_password_confirm = [];
                if(isset($form['fields']) && is_array($form['fields']) && count($form['fields'])>0) {
                    foreach($form['fields'] as $k=>$v) {
                        if($v->type == 'email' && isset($_POST['input_'.$v->id])) { // email
                            $_POST['input_'.$v->id] = $current_user->user_email;
                            $email['key'] = $k;
                            $email['value'] = $_POST['input_'.$v->id];
                         } elseif ($v->type == 'password' && $v->label == "Mot de passe actuel" && isset($_POST['input_'.$v->id])) { // password d'origine
                            $password['key'] = $k;
                            $password['value'] = $_POST['input_'.$v->id];
                        } elseif ($v->type == 'password' && $v->label == "Nouveau mot de passe" && isset($_POST['input_'.$v->id])) { // nouveau password
                            $new_password['key'] = $k;
                            $new_password['value'] = $_POST['input_'.$v->id];
                            if(isset($_POST['input_'.$v->id.'_2'])) { // confirmation du nouveau mot de passe
                                $new_password_confirm['key'] = $k;
                                $new_password_confirm['value'] = $_POST['input_'.$v->id.'_2'];                                
                            }
                        }
                    }
                }

                if( !empty($password['value']) && ( empty($new_password['value']) || empty($new_password_confirm['value']) ) ) {
                    $validation['is_valid'] = false;
                    add_filter( 'gform_validation_message', function ( $message, $form ) {
                        return '<div class="validation_error">Pour modifier votre mot de passe, veuillez renseigner le nouveau mot de passe et sa confirmation, autrement, veuillez laissez les trois champs vacant</div>';
                    }, 10, 2);
                    $form['fields'][$new_password['key']]->failed_validation = true;
                    $form['fields'][$new_password['key']]->validation_message = 'Erreur de mot de passe';
                    $form['fields'][$new_password_confirm['key']]->failed_validation = true;
                    $form['fields'][$new_password_confirm['key']]->validation_message = 'Erreur de mot de passe';
                    return $validation;
                }

                if( empty($password['value']) && (!empty($new_password['value']) || !empty($new_password_confirm['value']))) {
                    $validation['is_valid'] = false;
                    add_filter( 'gform_validation_message', function ( $message, $form ) {
                        return '<div class="validation_error">Pour modifier votre mot de passe, veuillez renseigner le mot de passe actuel</div>';
                    }, 10, 2);
                    $form['fields'][$password['key']]->failed_validation = true;
                    $form['fields'][$password['key']]->validation_message = 'Erreur de mot de passe';

                    return $validation;
                }


                if( !empty($password['value']) && !empty($new_password['value']) && !empty($new_password_confirm['value'])) {
                    $check = wp_authenticate_email_password( NULL, $email['value'], $password['value']); // VERIFICATION COUPLE MOT DE PASSE / EMAIL DANS LA BDD
                    if( is_wp_error($check)) {
                        $validation['is_valid'] = false;
                        add_filter( 'gform_validation_message', function ( $message, $form ) {
                            return '<div class="validation_error">Erreur de mot de passe</div>';
                        }, 10, 2);
                        $form['fields'][$password['key']]->failed_validation = true;
                        $form['fields'][$password['key']]->validation_message = 'Erreur de mot de passe';
                        return $validation;
                    }

                    if( $password['value'] == $new_password['value'] ) {
                        $validation['is_valid'] = false;
                        add_filter( 'gform_validation_message', function ( $message, $form ) { // Les 2 mots de passes ne sont pas différents
                            return '<div class="validation_error">L\'ancien mot de passe et le nouveau doivent être différent</div>';
                        }, 10, 2);
                        $form['fields'][$password['key']]->failed_validation = true;
                        $form['fields'][$password['key']]->validation_message = 'Erreur de mot de passe';
                        $form['fields'][$new_password['key']]->failed_validation = true;
                        $form['fields'][$new_password['key']]->validation_message = 'Erreur de mot de passe';
                    } else if ( $new_password['value'] !== $new_password_confirm['value']) {
                        $validation['is_valid'] = false;
                        add_filter( 'gform_validation_message', function ( $message, $form ) { // Les 2 mots de passes ne sont pas différents
                            return '<div class="validation_error">Le nouveau mot de passe et sa confirmation doivent être identique</div>';
                        }, 10, 2);
                        $form['fields'][$new_password['key']]->failed_validation = true;
                        $form['fields'][$new_password['key']]->validation_message = 'Erreur de mot de passe';
                        $form['fields'][$new_password_confirm['key']]->failed_validation = true;
                        $form['fields'][$new_password_confirm['key']]->validation_message = 'Erreur de mot de passe';
                    } else {
                        wp_set_password($new_password['value'], $current_user->ID);
                    }

                }

            }
        }

        return $validation;
    }

    /**
     * Gestion de la confirmation GF :
     * - Login : redirection (l'utilisateur a été loggué, on veut l'appliquer)
     */
    public function customConfirmation($confirmation, $form, $entry, $ajax)
    {
        global $wp;
        $redirect = [
			intval(get_field('opt_form_login', 'option')),
		];
        if(in_array($form['id'], $redirect)){
            // pas de confirmation, si on est arrivé là on recharge la page pour finir le login
            // @TODO bien vérifier qu'on est toujours envoyé vers la page souhaitée
            $redirectUrl = '/'.$wp->request;
            if(isset($entry['source_url'])){
                $redirectUrl = $entry['source_url'];
            }
            $confirmation = ['redirect' => $redirectUrl];
        }
        return $confirmation;
    }

    /**
     * A la validation du formulaire de mot de passe perdu, quand on demande un mail, interception des erreurs eventuelles pour ne pas aller sur le wp-login.php
     */
    public function onLostPasswordPost( $errors)
    {
        // si le login saisi n'est pas une adresse e-mail, on renvoi en erreur
        if(isset($_REQUEST['user_login']) && is_email($_REQUEST['user_login']) === false) {
            $message = "Le format de l'adresse e-mail n'est pas valide";
            $login = strip_tags($_REQUEST['user_login']);
            $redirect = get_home_url();
            if(isset($_REQUEST['redirect_current']) && strlen($_REQUEST['redirect_current']) > 0){
                $redirect = strip_tags($_REQUEST['redirect_current']);
            }
            $redirect .= '?rperror&err='.base64_encode($message).'&ul='.base64_encode($login);
            wp_safe_redirect($redirect);
            exit;
        }
        if(is_wp_error($errors) && count($errors->get_error_codes()) > 0) {
            $message = [];
            foreach($errors->errors as $t => $m){
                $message[] = $errors->get_error_message($t);
            }
            $redirect = get_home_url();
            if(isset($_REQUEST['redirect_current']) && strlen($_REQUEST['redirect_current']) > 0){
                $redirect = strip_tags($_REQUEST['redirect_current']);
            }else{
                return;
            }
            $login = '';
            if(isset($_REQUEST['user_login'])){
                $login = strip_tags($_REQUEST['user_login']);
            }
            $redirect .= '?rperror&err='.base64_encode(implode('<br>', $message)).'&ul='.base64_encode($login);
            wp_safe_redirect($redirect);
            exit;
        }
    }

	/**
	 * gestion des viewcomposer associées au compte
	 */
	public function initViewComposer()
	{
		// mot de passe oublié
		\View::composer('elements.modules.lostpassword', function($view) {
            td("test 2");
            $currentUrl = home_url();
            global $wp;
            if(isset($wp->request) && strlen($wp->request)>0){
                $currentUrl = home_url($wp->request);
            }
            $login = '';
            if(isset($_GET['ul'])){
                $login = strip_tags(addslashes(base64_decode($_GET['ul'])));
            }
            $error = null;
            if(isset($_GET['err'])){
                $error = strip_tags(base64_decode($_GET['err']));
            }
            $view
                ->with('rpSent', isset($_GET['rpsent']))
                ->with('error', $error)
            ;
		});

	}

    public function lostPasswordRedirect($user, $new_pass)
    {
        $login = isset($_POST['user_login']) ? strip_tags($_POST['user_login']) : '';
        $password = isset($_POST['pass1']) ? strip_tags($_POST['pass2']) : '';
        $check = wp_authenticate_username_password( NULL, $login, $password);
        if(!is_wp_error($check)){
            $user_id = $check->ID;
            wp_set_current_user($check->ID, $login);
            wp_set_auth_cookie($check->ID);
            do_action('wp_login', $login);
        }
        wp_redirect(home_url());
        exit;
    }

    /**
     * En cas de mail de reset de password, voici la valeur a mettre pour le champ "message"
     */
    public function changeRetrievePasswordMessage($message, $key, $user_login, $user_data)
    {
        return view( 'generation.mail-reset-password', [ 'key' => $key, 'user_login' => $user_login ] );
    }

    /**
     * En cas de mail de reset de password, voici la valeur a mettre pour le champ "from"
     */
    public function changeRetrievePasswordTitle( $title, $user_login, $user_data) {
        $title = "Demande de réinitialisation de mot de passe";
        return $title;
    }

    /**
     * En cas de mail de reset de password, voici la valeur a mettre pour le champ "from"
     */
    public function customFromFieldMail($args) {
        // Si reset password ou alerte nouveauté
        if( isset($_GET) && isset($_GET["action"]) && ( $_GET["action"] == "lostpassword" || $_GET["action"] == "alertemail" )) {
            return "no-reply@paramountpictures.fr";
        }
        return $args;
    }

    /**
     * En cas de mail de reset de password, voici la valeur a mettre pour le champ "from"
     */
    public function customFromNameFieldMail($args) {
        // Si reset password ou alerte nouveauté
        if( isset($_GET) && isset($_GET["action"]) && ( $_GET["action"] == "lostpassword" || $_GET["action"] == "alertemail" )) {
            return "Paramount Pictures France";
        }
        return $args;
    }

    /**
     * En cas de mail de reset de password, voici la valeur a mettre pour le champ "Content-type"
     */
    public function customeContentTypeMail($args) {
        // Si reset password ou alerte nouveauté
        if( isset($_GET) && isset($_GET["action"]) && ( $_GET["action"] == "lostpassword" || $_GET["action"] == "alertemail" )) {
            return "text/html";
        }
        return $args;
    }


	//===========================================================================
    //      Gestion écran profile utilisateurs
    //===========================================================================

	/**
	 * Ajout de champ meta dans la page de profile d'un utilisateur
	 */
	function add_field_to_account_view() {

		$fields = $this->_get_account_fields();

		?>
		<h2><?php _e( 'Information Supplémentaire', '_pit' ); ?></h2>
		<table class="form-table" id="_pit-additional-information">
			<tbody>
			<?php foreach ( $fields as $key => $field_args ) { ?>
				<?php
	
				if ( ! empty( $field_args['hide_in_admin'] ) ) {
					continue;
				}
	
				$user_id = $this->_get_edit_user_id();
				$value   = $this->_get_userdata( $user_id, $key );

				?>
				<tr>
					<th>
						<label for="<?php echo $key; ?>"><?php echo $field_args['label']; ?></label>
					</th>
					<td>
						<?php $field_args['label'] = false; ?>
						<input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value ?>"  class="regulat-text"></input>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php
	}

	function _get_edit_user_id() {
		return isset( $_GET['user_id'] ) ? (int) $_GET['user_id'] : get_current_user_id();
	}

	function _get_userdata( $user_id, $key ) {
		if ( ! $this->_is_userdata( $key ) ) {
			return get_user_meta( $user_id, $key, true );
		}
	
		$userdata = get_userdata( $user_id );
	
		if ( ! $userdata || ! isset( $userdata->{$key} ) ) {
			return '';
		}
	
		return $userdata->{$key};
	}

	function _is_userdata( $key ) {
		$userdata = array(
			'user_pass',
			'user_login',
			'user_nicename',
			'user_url',
			'user_email',
			'display_name',
			'nickname',
			'first_name',
			'last_name',
			'description',
			'rich_editing',
			'user_registered',
			'role',
			'jabber',
			'aim',
			'yim',
			'show_admin_bar_front',
		);
	
		return in_array( $key, $userdata );
	}

	function _get_account_fields()
	{

		return apply_filters( '_pit_account_fields', [
		
			'telephone' => [
				'type'              => 'number',
				'label'             => __( 'Téléphone', 'pilot-theme' ),
				'placeholder'       => __( 'Téléphone', 'pilot-theme' ),
			],
			'media_cinema_name' => [
				'type'              => 'text',
				'label'             => __( 'Nom du média / Cinéma', 'pilot-theme' ),
				'placeholder'       => __( 'Nom du média / Cinéma', 'pilot-theme' ),
			],
			'postal_code' => [
				'type'              => 'text',
				'label'             => __( 'Adresse Postal', 'pilot-theme' ),
				'placeholder'       => __( 'Adresse Postal', 'pilot-theme' ),
			],

		] );
		
	}


}
