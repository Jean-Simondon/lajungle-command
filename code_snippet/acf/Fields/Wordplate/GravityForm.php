<?php

declare(strict_types=1);

namespace YOUR_THEME_NAME_CAMEL\Acf\Fields\Wordplate;

use WordPlate\Acf\Fields\Field;

use WordPlate\Acf\Fields\Attributes\ConditionalLogic;
use WordPlate\Acf\Fields\Attributes\Instructions;
use WordPlate\Acf\Fields\Attributes\Required;
use WordPlate\Acf\Fields\Attributes\ReturnFormat;
use WordPlate\Acf\Fields\Attributes\Nullable;
use WordPlate\Acf\Fields\Attributes\Multiple;

class GravityForm extends Field
{
    use ConditionalLogic;
    use Instructions;
    use Required;
    use ReturnFormat;
    use Nullable;
    use Multiple;

    protected $type = 'forms';

    public function __construct(string $label, ?string $name = null)
    {
    	parent::__construct($label, $name);
    }
}
