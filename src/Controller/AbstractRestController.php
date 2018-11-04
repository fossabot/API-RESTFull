<?php declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class RestController.
 */
abstract class AbstractRestController
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var FormFactoryInterface $form */
    protected $form;

    /**
     * AbstractRestController constructor.
     */
    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form)
    {
        $this->em = $em;
        $this->form = $form;
    }
}
