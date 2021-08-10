<?php
namespace YOUR_THEME_NAME\Helpers;

class NewsletterHelper
{

    public static $table_name = 'newsletter_laseigneurie';

    /**
     * Crée la table wp_newsletter_laseigneurie dans la base de données
     */
    public static function createTable()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            user_email varchar(100) NOT NULL,
            user_name varchar(100) NOT NULL,
            user_surname varchar(100) NOT NULL,
            user_resident_name varchar(100) NOT NULL,
            PRIMARY KEY  (user_email)
          ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    /**
     * Vérifie que la table existe bien
     */
    public static function isTableNewsletter()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;
        $answer = $wpdb->get_results("SELECT * from INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$table_name'");
        if( !empty($answer) && is_array($answer) && count($answer) > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Vérifier que la table existe, que l'adresse mail n'existe pas déjà dans la bdd puis inscrit l'adresse email dans un nouveau tuple
     */
    public static function write($mail, $nom, $prenom, $resident)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        if( !self::isTableNewsletter()) {
            self::createTable();
        }

        if( self::find($mail) == false) {
            $wpdb->insert(
                $table_name,
                [
                    'user_email' => $mail,
                    'user_name' => $nom,
                    'user_surname' => $prenom,
                    'user_resident_name' => $resident,
                ]
            );
        }
    }

    /**
     * Retourne vrai si $value existe déjà dans la base de données en tant qu'attribut user_email
     */
    public static function find($value)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        if( !self::isTableNewsletter()) {
            self::createTable();
        }

        $answer = $wpdb->get_row("SELECT * from $table_name WHERE user_email = '$value'");

        if(!empty($answer)) {
            return $answer;
        } else {
            return false;
        }

    }


    /**
     * Renvoie la totalité des tuples de la base de données
     */
    public static function readAll()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        if( !self::isTableNewsletter()) {
            self::createTable();
        }

        $answer = $wpdb->get_results("Select * from $table_name");
        return $answer;
    }

    /**
     * Supprime le tuple à l'emplacement ou $value est égale à user_email
     */
    public static function delete($value)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        if( !self::isTableNewsletter()) {
            self::createTable();
        }

        $wpdb->delete( $table_name, array( 'user_email' => $value ) );
    }



}