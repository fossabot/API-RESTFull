<?php declare(strict_types=1);

namespace App\Controller\Article;

use App\Controller\AbstractRestController;
use App\Entity\Article;
use App\Form\ArticleType;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class putArticleController.
 */
class putArticleController extends AbstractRestController
{
    /**
     * @ApiDoc()
     *
     * @FOSRest\View(statusCode=201)
     *
     * @Route(name="put_article", path="/article/{id}", methods={"PUTT"})
     *
     * @param Article $article
     * @param Request $request
     *
     * @return array|FormInterface
     */
    public function put(Request $request, Article $article)
    {
        $form = $this->form->createNamed('', ArticleType::class, $article);
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $this->em->flush();

            return ['article' => $article];
        }

        return $form;
    }
}
