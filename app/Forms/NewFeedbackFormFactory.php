<?php
declare(strict_types=1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

use App\Model;


final class NewFeedbackFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;


        /** @var Nette\Localization\ITranslator */
        private $translator;
        
        /** @var Model\Feedbacks */
        private $feedbacks;
        
        
        
       
	public function __construct(FormFactory $factory, Model\Feedbacks $feedbacks, Nette\Localization\ITranslator $translator)
	{
		$this->factory = $factory;
                $this->translator = $translator;
                $this->feedbacks = $feedbacks;
	}

        
        public function create(callable $onSuccess): Form
	{
		$form = $this->factory->create();
                $form->setTranslator($this->translator);
		$form->addEmail('feed_email')->setRequired("Prosím vyplňte E-mail.");
                $form->addText('feed_text')->setRequired("Prosím vyplňte Váš dotaz.");
		$form->addSubmit('send');
		$form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
                    $this->feedbacks->insert($values->feed_email, $values->feed_text);
                    $onSuccess();
		};
                
		return $form;
	}
        
}

