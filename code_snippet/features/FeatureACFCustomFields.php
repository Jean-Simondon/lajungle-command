<?php 
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;

class FeatureACFCustomFields extends FeatureManager
{
	protected function _initHooks()
	{
        add_filter('acf/validate_value/type=page_link', [$this, 'return_public_cpt'], 10, 4);
        add_filter('acf/validate_value/type=page_link', [$this, 'return_event_cpt'], 10, 4);
    }

    public function return_public_cpt($valid, $value, $field, $input)
    {    
        if (!$valid) return $valid;
        
        if (empty($field['is_public'])) return $valid;

        $cptId = $value;
        $cpt = get_post($cptId);
        $cptShowOn = get_field('show_on', $cptId);

        if (!in_array('public', $cptShowOn)) {
            $valid = sprintf(__('La ressource "%s" n\'est pas publique et ne peut par conséquent pas être mise en avant sur l\'espace public.'), $cpt->post_name);
        }
        
        return $valid;	
    }

    public function return_event_cpt($valid, $value, $field, $input)
    {    
        if (!$valid) return $valid;
        
        if (empty($field['is_event'])) return $valid;

        $cptId = $value;
        $cpt = get_post($cptId);
        $cptIsEvent = get_field('actu_event', $cptId);

        if (is_null($cptIsEvent) || !in_array('event', $cptIsEvent)) {
            $valid = sprintf(__('L\'actu "%s" n\'est pas un événement et ne peut par conséquent pas être mise en avant dans la section événements.'), $cpt->post_name);
        }
        
        return $valid;	
    }
}