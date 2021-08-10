<?php
namespace YOUR_THEME_NAME\Helpers;

class EmailHelper
{
	public static function send($email, $name = '', $tpl, $subject = '', $args = [])
	{
		$contentEmail = \View::make($tpl, $args);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'To: '.$name.' <'.$email.'>' . "\r\n";
		$headers .= 'From: Idate <noreply@idate.com.com>' . "\r\n";
		return wp_mail( $email, __($subject, 'idate'), $contentEmail, $headers );
	}

    protected static $mailDir = '/resources/mails';

    public static function buildMail($title, $message, $button = '', $textButton = 'Mon espace privé')
    {
        $mailDir = get_stylesheet_directory() . self::$mailDir . '/';
        $mailHeader = file_get_contents($mailDir . 'header.php');
        $mailBodyBefore = file_get_contents($mailDir . 'bodyStart.php');
        $mailBodyAfter = file_get_contents($mailDir . 'bodyMiddle.php');
        $mailButtonBefore = file_get_contents($mailDir . 'beforeButton.php');
        $mailButtonAfter = file_get_contents($mailDir . 'afterButton.php');
        $mailButtonEnd = file_get_contents($mailDir . 'endButton.php');
        $mailEnd = file_get_contents($mailDir . 'bodyEnd.php');

        $mailToUser = $mailHeader . $title . $mailBodyBefore . $message;

        if ($button != '') {
            $mailToUser .= $mailButtonBefore . $button . $mailButtonAfter . $textButton .$mailButtonEnd;
        }
        
        $mailToUser .= $mailBodyAfter . $mailEnd;

        return $mailToUser;
    }


}
