<?php

namespace App\Form\Exception;

use Symfony\Component\Form\FormInterface;

/**
 * InvalidFormException.
 */
class InvalidFormException extends \RuntimeException
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @param string        $message
     * @param FormInterface $form
     */
    public function __construct($message, FormInterface $form = null)
    {
        parent::__construct($message);

        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
}
