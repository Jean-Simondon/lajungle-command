<?php
namespace YOUR_THEME_NAME\Features;

use YOUR_THEME_NAME\Helpers\NewsletterHelper;

use Iquitheme\Core\Features\FeatureManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FeatureNewsletter extends FeatureManager
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _initHooks()
	{
        add_action('admin_menu', [$this, 'add_newsletter_la_seigneurie_option_page']);
        add_action('init', [$this, 'create_excel']);
        add_action('init', [$this, 'download_excel']);
    }

	// ------- CREATION DE LA PAGE D'OPTION NEWSLETTER ---------------
    function add_newsletter_la_seigneurie_option_page()
    {
		add_menu_page('Newsletter', 'Newsletter', 'administrator', 'newsletter_la-seigneurie_option-page', [$this, 'add_content_page_la_seigneurie']);
	}

	// --------- CONTENU DE LA PAGE D'OPTION NEWSLETTER ET SA LOGIQUE ---------------
    function add_content_page_la_seigneurie()
    {

        // Quand on vient du bouton de suppression d'une ligne
            if( isset($_GET) && isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['target'])) {
                $user = NewsletterHelper::find($_GET['target']);
                NewsletterHelper::delete($_GET['target']);

                if($user !== false) {
                    $message = "L'utilisateur [$user->user_email, $user->user_name, $user->user_surname, $user->user_resident_name] a bien été retiré des abonnées de la newsletter";
                } else {
                    $message = "Erreur de suppression d'utilisateur";
                }
            }

            $users = NewsletterHelper::readAll();
            $count = 0;
    

        ?>
            <div class="wrap">
                <h1>Newsletter La Seigneurie : Abonnés</h1>
                    <br>
                    <?php if(isset($message)) { ?>
                        <p><?= $message ?></p>
                    <?php } ?>
                    <!-- Bouton de téléchargement -->
                    <a href="/cms/wp-admin/admin.php?page=newsletter_la-seigneurie_option-page&action=create_excel" class="button button-primary">Télécharger au format excel</a>
                    <table class="form-table">
                        <!-- Schéma de la table -->
                        <tr valign="top">
                            <th scope="row"></th>
                            <th scope="row">Email</th>
                            <th scope="row">Nom</th>
                            <th scope="row">Prénom</th>
                            <th scope="row">Nom de résident</th>
                        </tr>
                        <!-- Liste des adhérents à la newsletter -->
                        <?php foreach($users as $user) { ?>
                        <?php $count++; ?>
                            <tr valign="top">
                                <th scope="row"><?= $count ?></th>
                                <th scope="row"><?= $user->user_email ?></th>
                                <th scope="row"><?= $user->user_name ?></th>
                                <th scope="row"><?= $user->user_surname ?></th>
                                <th scope="row"><?= $user->user_resident_name ?></th>
                                <th><a href="/cms/wp-admin/admin.php?page=newsletter_la-seigneurie_option-page&action=delete&target=<?= $user->user_email ?>" class="button button-primary">Supprimer</a></th>
                            </tr>
                        <?php } ?>
                    </table>
            </div>
		<?php

    }

	// --------- CREATION DU FICHIER EXCEL ET REDIRECTION ---------------
    function create_excel()
    {
        $users = NewsletterHelper::readAll();
        if(isset($_GET) && isset($_GET['action']) && $_GET['action'] == 'create_excel') {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            foreach($users as $k => $v) {
                $email_cell = "A" . ($k+1);
                $name_cell = 'B' . ($k+1);
                $surname_cell = 'C' . ($k+1);
                $resident_cell = 'D' . ($k+1);
                $sheet->setCellValue($email_cell, $v->user_email);
                $sheet->setCellValue($name_cell, $v->user_name);
                $sheet->setCellValue($surname_cell, $v->user_surname);
                $sheet->setCellValue($resident_cell, $v->user_resident_name);
            }

            $writer = new Xlsx($spreadsheet);

            $uploaddir = wp_upload_dir(); // répertoire d'arrivée
            if(!is_dir($uploaddir['basedir'] . '/newsletter')) {
                mkdir($uploaddir['basedir'] . '/newsletter');
            }

            $file_url = $uploaddir['basedir'] . '/newsletter/newsletter_abonnes.xlsx';

            $writer->save( $file_url );
            
            $uploadfile = $uploaddir['basedir'] . '/newsletter/newsletter_abonnes.xlsx'; // fichier d'arrivée
            if(file_exists($uploadfile)) {
                rename($uploadfile, $uploaddir['basedir'] . '/newsletter/newsletter_abonnes.xlsx');
            }

            wp_safe_redirect("/cms/wp-admin/admin.php?page=newsletter_la-seigneurie_option-page&action=download_newsletter");
            exit;
        }
    }

	// --------- TELECHARGEMENT DU FICHIER EXCEL ---------------
    public function download_excel()
    {
        if( !empty($_GET) && isset($_GET['action']) && $_GET['action'] == 'download_newsletter' ) {
            $uploaddir = wp_upload_dir();
            if(file_exists($uploaddir['basedir'] . '/newsletter/newsletter_abonnes.xlsx')) {
                $uploadfile = $uploaddir['baseurl'] . '/newsletter/newsletter_abonnes.xlsx';
                wp_safe_redirect('/content/uploads/newsletter/newsletter_abonnes.xlsx');
            } else {
                wp_safe_redirect("/cms/wp-admin/admin.php?page=newsletter_la-seigneurie_option-page");
                exit;
            }
        }
    }

}