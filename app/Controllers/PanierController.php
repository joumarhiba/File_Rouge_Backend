<?php

require_once('app/Models/Organisateur.php');
require_once('app/Models/Panier.php');
require_once('app/Models/Event.php');


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8 ");
header("Access-Control-Allow-Methods: * ");
header("Access-Control-Allow-Max-Age: 3600 ");
header("Access-Control-Allow-Headers: * ");

class PanierController {
    public function all(){
        $data = json_decode(file_get_contents('php://input'));
        $idOrganisateur = $data->idOrganisateur;
        $e = new Panier();
        $res = $e->getAll($idOrganisateur);
        if ($res) {
            $array = array();
            $array['data'] = array();

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $event = array(
                    'nomEvent'=>$nomEvent,
                    'tarif'=>$tarif,
                    'img'=>$img,
                    'idOrganisateur'=>$idOrganisateur,
                    'idEvent' => $idEvent,
                    'idPanier' => $idPanier,
                    'qte' => $qte,

                );
                array_push($array['data'],$event);
            }
        echo json_encode($array);
        }else {
            echo json_encode(
                array('message'=>'no data about the event and the cart ...........')
            );
        }
    }

    public function ticketsById() {
        $data = json_decode(file_get_contents('php://input'));
        $idOrganisateur = $data->idOrganisateur;
        echo json_encode(array("msg"=> $idOrganisateur));
        $e = new Panier();
        $res = $e->ticketsById($idOrganisateur);
        if ($res) {
            $array = array();
            $array['data'] = array();

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $event = array(
                    'nomEvent'=>$nomEvent,
                    'tarif'=>$tarif,
                    'img'=>$img,
                    'idOrganisateur'=>$idOrganisateur,
                    'idEvent' => $idEvent
                );
                array_push($array['data'],$event);
            }
        echo json_encode($array);
        }else {
            echo json_encode(
                array('message'=>'no data event .....')
            );
        }
    }

    public function add() {
        $data = json_decode(file_get_contents('php://input'));
        $idEvent = $data->idEvent;
        $idOrganisateur = $data->idOrganisateur;
        $tarif = $data->tarif;

        $e = new Panier();
        $row = $e->addToPanier($idEvent, $idOrganisateur, $qte=1, $tarif);
        if($row) {
            echo json_encode(array('msg'=>'it\'s added to the panier now'));
        }else {
            echo json_encode(array('msg'=>'No'));
        }
    }

    public function deleteEvent() {
        $data = json_decode(file_get_contents('php://input'));
        $idPanier = $data->idPanier;
        $e = new Panier();
        $row = $e->remove($idPanier);

        if($row) {
            echo json_encode(array("msg"=>"l evenement est suprimé du panier avec succès"));
        } else {
            echo json_encode(array('msg'=> 'evenement NON SUP pfffffff'));
        }
    }

    public function plusOne() {
        $data = json_decode(file_get_contents('php://input'));
        $idPanier = $data->idPanier;
        $qte = $data->qte;
        $tarif = $data->tarif;
        $event = new Panier();
        $qte = $qte + 1;
        $tarif = $qte * $tarif;
        $row = $event->plusOne($idPanier, $qte, $tarif);
        if($row) {
            echo json_encode(array('msg'=> 'plus un : '.$qte.' et le tarif est devenu '.$tarif));
        } else {
            echo json_encode(array('msg'=> 'the same... no change'));
        }
    }

    public function minusOne() {
        $data = json_decode(file_get_contents('php://input'));
        $idPanier = $data->idPanier;
        $qte = $data->qte;
        $tarif = $data->tarif;
        $event = new Panier();
        $tarifUnitaire = $tarif / $qte;
        $newqte = $qte - 1;
        $tarifFinal = $tarifUnitaire * $newqte;
        $row = $event->minusOne($idPanier, $newqte, $tarifFinal);
        if($newqte == 0) {
            $row = $event->remove($idPanier);
            echo json_encode(array('msg'=> 'cet événement sera supprimé '.$newqte));
        }
        else if($row) {
            echo json_encode(array('msg'=> 'moins un : '.$newqte.' et le tarif est devenu '.$tarifFinal));
        } else {
            echo json_encode(array('msg'=> 'the same ... no change'));
        }
    }

    public function updateTarif() {
        $data = json_decode(file_get_contents('php://input'));
        // echo json_encode(array('msg'=> $data));
        $idPanier = $data->idPanier;
        $tarif = $data->tarif;
        $qte = $data->qte;
        $tarif = $tarif * $qte;
        $e = new Panier();
        $row = $e->updateTarif($idPanier, $tarif, $qte);
        if($row) {
            echo json_encode(array('msg'=> $tarif));
        }
        else {
            echo json_encode(array('msg'=> 'noooooooo'));
        }
    }
}