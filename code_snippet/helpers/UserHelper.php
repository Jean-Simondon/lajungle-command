<?php
namespace YOUR_THEME_NAME\Helpers;

class UserHelper
{
    
    /**
     * @param $role
     * @return bool
     * Vérifie si l'utilisateur a le role $role
     */
    public static function hasRole($role){
        if(empty($role)) return false;
        global $wp_roles, $current_user;
        if($wp_roles->is_role($role)){
            if(in_array($role,$current_user->roles)){
                return true;
            }
        }
        return false;
    }

    // /**
    //  * @param $role
    //  * @return bool
    //  * Ajoute le role $role à l'utilisateur
    //  */
    public static function addRole($role){
        if(empty($role) || $role===ROLE_ADMINISTRATOR) return false;
        global $wp_roles, $current_user;
        if($wp_roles->is_role($role)) {
            $current_user->add_role($role);
            return true;
        }
        return false;
    }

    // /**
    //  * @param $role
    //  * @return bool
    //  * Enlève le role $role à l'utilisateur
    //  */
    // public static function removeRole($role){
    //     if(empty($role) || $role===ROLE_ADMINISTRATOR) return false;
    //     global $wp_roles, $current_user;
    //     if($wp_roles->is_role($role)) {
    //         $current_user->remove_role($role);
    //         return true;
    //     }
    //     return false;
    // }

    // une fonction pour enregister l'id d'un film comme favoris d'un utilisateur
    public static function set_favoris($idUser, $filmID)
    {
        if (metadata_exists('user', $idUser, 'film_favoris') && get_user_meta($idUser, 'film_favoris') !== NULL && count(get_user_meta($idUser, 'film_favoris')) > 0 ) {
            $actual = UserHelper::get_favoris($idUser);
            foreach($filmID as $id) {
                if (is_array($actual) && !in_array($id, $actual)) {
                    $actual[] = $id;
                }
            }
            update_user_meta($idUser, 'film_favoris', $actual);
            return true;
        } else {
            add_user_meta($idUser, 'film_favoris', $filmID);
            return true;
        }
        return false;
    }

    public static function get_favoris($idUser)
    {
        if(metadata_exists('user', $idUser, 'film_favoris')) {
            return get_user_meta($idUser, 'film_favoris')[0];
        } else {
            return false;
        }
    }

    public static function unset_favoris($idUser, $filmID)
    {
        $actual = UserHelper::get_favoris($idUser);
        foreach($filmID as $id) {
            if (is_array($actual) && in_array($id, $actual)) {
                unset($actual[array_search($id, $actual)]);
            }
        }
        delete_user_meta($idUser, 'film_favoris');
        add_user_meta($idUser, 'film_favoris', $actual);
    }

    public static function has_favoris($idUser)
    {
        return metadata_exists('user', $idUser, 'film_favoris') && get_user_meta($idUser, 'film_favoris') !== NULL && count(get_user_meta($idUser, 'film_favoris')) > 0 ;

    }

}
