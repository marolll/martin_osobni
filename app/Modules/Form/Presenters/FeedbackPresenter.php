<?php

declare(strict_types=1);

namespace App\Modules\Form;
use App\Forms;
use App\Model;
use Nette\Application\UI\Form;


final class FeedbackPresenter extends \App\Presenters\BasePresenter

{

        /** @var Forms\NewFeedbackFormFactory @inject*/
        public $newFeedbackFactory;
    
        /** @var Model\Feedbacks @inject*/
        public $feedbacks;
    
	public function renderDefault()
	{

	}
        public function renderNew() {
            
        }
    
        
    /**
    * NewFeedback form factory.
    */
    protected function createComponentNewFeedbackForm(): Form
    {
        return $this->newFeedbackFactory->create(function (): void {
                $this->redirect(':Form:Feedback:feedbackSent');
        });          	
    }
}
