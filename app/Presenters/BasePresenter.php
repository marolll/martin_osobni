<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Contributte;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @persistent */
    public $locale;
    
    /** @var Nette\Localization\ITranslator @inject */
    public $translator;

    /** @var Contributte\Translation\LocalesResolvers\Session @inject */
    public $translatorSessionResolver;
    
     /** @var Nette\Database\Explorer @inject */
    private $database;
    


    public function handleChangeLocale(string $locale): void
    {
        $this->translatorSessionResolver->setLocale($locale);
        $this->redirect('this');
    }
    
    public function startup() {
        parent::startup();
        $this->template->locale = $this->locale;
    }
    
   
     
     
     public function __construct(Nette\Database\Explorer $database) {
         $this->database = $database;
     }
     
     public function renderDefault(): void {
         $this->template->feedbacks = $this->database->table('posts')
                 ->order('feed_id DESC')
                 ->limit(5);
     }
     
     
     
}
