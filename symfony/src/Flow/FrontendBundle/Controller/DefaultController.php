<?php

namespace Flow\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $min_user_id = 10521598;
        $max_user_id = 15262754;
        $user_id = 10521598;
        $user_repo = $this->getDoctrine()->getManager()->getRepository('FlowFrontendBundle:User');
        $user = $user_repo->find(10521598);

        $sql = "
        SELECT Card.*, count(l.card_id) as l_count, count(f.card_id) as f_count
          FROM Card
          LEFT JOIN users_cards_likes l ON Card.id = l.card_id
          LEFT JOIN users_cards_followers f ON Card.id = f.card_id
          WHERE Card.owner_id = ".$user_id."
          GROUP BY Card.id
    ";

        $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
        $cards = $stmt->fetchAll();
        return $this->render('FlowFrontendBundle:Default:index.html.twig', array('cards' => $cards, 'user' => $user));
    }

    public function randomAction()
    {
        $min_user_id = 10521598;
        $max_user_id = $min_user_id + 1000;
        $user_id = rand($min_user_id, $max_user_id);

        $sql = "
        SELECT Card.*, count(l.card_id) as l_count, count(f.card_id) as f_count
          FROM Card
          LEFT JOIN users_cards_likes l ON Card.id = l.card_id
          LEFT JOIN users_cards_followers f ON Card.id = f.card_id
          WHERE Card.owner_id = ".$user_id."
          GROUP BY Card.id
    ";

        $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
        $stmt->execute();
        $cards = $stmt->fetchAll();

        $user_repo = $this->getDoctrine()->getManager()->getRepository('FlowFrontendBundle:User');
        $user = $user_repo->find($user_id);

        return $this->render('FlowFrontendBundle:Default:index.html.twig', array('cards' => $cards, 'user' => $user));
    }

    public function staticAction(){
        return $this->render('FlowFrontendBundle:Default:static.html.twig');
    }
}
