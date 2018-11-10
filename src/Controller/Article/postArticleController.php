<?php declare(strict_types=1);

namespace App\Controller\Article;

use App\Controller\AbstractRestController;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Security\UserResolver;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class postArticleController.
 */
class postArticleController extends AbstractRestController
{
    /** @var UserResolver $userResolver */
    private $userResolver;

    /**
     * postArticleController constructor.
     * @param EntityManagerInterface $em
     * @param FormFactoryInterface $form
     * @param UserResolver $userResolver
     */
    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, UserResolver $userResolver)
    {
        parent::__construct($em, $form);
        $this->userResolver = $userResolver;
    }

    /**
     * @ApiDoc()
     *
     * @FOSRest\View(statusCode=201)
     *
     * @Route(name="post_article", path="/article", methods={"POST"})
     *
     * @param Request $request
     * @return array|FormInterface
     */
    public function __invoke(Request $request)
    {
        $article = new Article();
        $article->setAuthor($this->userResolver->getCurrentUser());
        $form = $this->form->createNamed('', ArticleType::class, $article);
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $this->em->persist($article);
            $this->em->flush();

            return ['article' => $article];
        }

        return $form;
    }
}
