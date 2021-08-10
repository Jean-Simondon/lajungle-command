<?php
namespace YOUR_THEME_NAME\Features;

class FeatureMailTrap extends FeatureManager
{
    protected function _initHooks()
    {
        add_action('phpmailer_init', [$this, 'mailtrap']);
    }

    public function mailtrap($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'xxxxxxxxxxxxxx';
        $phpmailer->Password = 'xxxxxxxxxxxxxx';
    }
}