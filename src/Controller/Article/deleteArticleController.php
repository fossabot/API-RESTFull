<?php declare(strict_types=1);

namespace App\Controller\Article;

use App\Controller\AbstractRestController;
use App\Entity\Article;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class deleteArticleController.
 */
class deleteArticleController extends AbstractRestController
{
    /**
     * @ApiDoc()
     *
     * @param Article $article
     *
     * @Route(name="delete_article", path="/article/{id}", methods={"DELETE"})
     *
     * @FOSRest\View(statusCode=204)
     */
    public function __invoke(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();
    }
}
