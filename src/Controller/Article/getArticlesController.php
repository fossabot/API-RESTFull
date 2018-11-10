<?php declare(strict_types=1);

namespace App\Controller\Article;

use App\Controller\AbstractRestController;
use App\Entity\Article;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class getArticlesController.
 */
class getArticlesController extends AbstractRestController
{
    /**
     * @ApiDoc()
     *
     * @FOSRest\View(statusCode=200)
     *
     * @Route(name="get_articles", path="/articles", methods={"GET"})
     *
     * @return Article[]|object[]
     */
    public function __invoke()
    {
        return $this->em->getRepository(Article::class)->findAll();
    }
}
