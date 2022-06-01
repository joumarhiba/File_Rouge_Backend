<?php
require('app/Models/Organisateur.php');
require('app/Models/Event.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8 ");
header("Access-Control-Allow-Methods: * ");
header("Access-Control-Allow-Max-Age: 3600 ");
header("Access-Control-Allow-Headers: * ");

class OrganisateurController{


    public function all(){
        $org = new Organisateur();
        $res = $org->getAllOrganisateurs();

        if($res){
            $data['data'] = array();

            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $org = array(
                    'username'=>$username,
                    'email'=>$email
                );
                array_push($data['data'],$org);
            }
            echo json_encode($data);
        }else {
            echo json_encode(
                array('message'=> 'nothingggggggg')
            );
        }
    }

    public function register()
    {

        $data =json_decode(file_get_contents('php://input'));

        if(isset($data->username) && isset($data->email) && isset($data->mdp)){
            $username = $data->username;
            $email = $data->email;
            $mdp = $data->mdp;

        }else{
            echo json_encode(
                array("message"=>"noo data from register")
            );
        }

        if (!empty($username) && !empty($email)  && !empty($mdp)) {

            $result = new Organisateur();
            if($result->addOrganisateur($username, $email, $mdp)){
                        if ($result ) {
                            echo json_encode(
                                array("message"=>"organisateur Account created")
                            );
                        }else
                        {
                            echo json_encode(
                                array("message"=>"something wrong with SIGN UP")
                            );

                        }
            }else {
                echo json_encode(
                    array("message"=>$result)
                );
            }
        }
    }


    public function login(){
        $data = json_decode(file_get_contents('php://input'));
        $email = $data->email;
        if(isset($email) && isset($data->mdp)){
            $data = [];
            $data['data'] = [];
            $org = new Organisateur();
            if ($result = $org->getOrganisateur($email)){
                extract($result);
                echo $idOrganisateur;
            } else {
                $message = array(
                    'message' => 'this organisateur is NOT Found'
                );
                array_push($data['data'],$message);
                echo json_encode($data);
            }
        }
    }


public function logout(){
    session_start();
    session_unset();
    session_destroy();
    View::load("home");
}


    // public function viewPosts()
    // {
    //     $cnx = new Base();
    //     $aff = $cnx->selectAll();
    //     $data['posts']= $aff;

    //     View::load("posts/viewPosts",$data);//à ne pas changer
    // }

    public function addEvent()
    {
        $data =json_decode(file_get_contents("php://input"));
        $nomEvent = $data->nomEvent;
        $typeEvent = $data->typeEvent;
        $villeEvent = $data->villeEvent;
        $dateDebut = $data->dateDebut;
        $nbMax = $data->nbMax;
        $tarif = $data->tarif;

        if (isset($nomEvent)){
            echo json_encode(array("message"=>'heyyyyyy'));
        }
    }
    public function infosEvent()
    {
        // if (isset($_POST['add']))
        // {
        //     session_start();
        //     $nomEvent = $_POST["nomEvent"];
        //     $typeEvent = $_POST["typeEvent"];
        //     $villeEvent = $_POST["villeEvent"];
        //     $dateDebut = $_POST["dateDebut"];
        //     $duree = $_POST["duree"];
        //     $nbMax = $_POST["nbMax"];
        //     $tarif = $_POST["tarif"];
        //     $idOrganisateur = $_SESSION['id'];
        //     $photo = $_FILES["img"]['name'];
        //     $upload = "/public/assets/".$photo;
        //     if (!empty($nomEvent) && !empty($typeEvent) && !empty($photo) && !empty($villeEvent) && !empty($dateDebut) && !empty($duree) && !empty($nbMax) && !empty($tarif)) {
        //         move_uploaded_file($photo,$upload);
        //         $conn = new Event();
        //          $event = $conn->AddEvent($nomEvent, $typeEvent, $villeEvent,$dateDebut, $duree, $nbMax,$tarif, $idOrganisateur);
        //         //  $this->viewPosts();
        //         // normalemnt il doit se deriger vers dashboard et non home
        //         View::load("home");

        //          if($event){
        //             View::load("posts/viewPosts");
        //          }else{
        //             echo "ereur";
        //          }
        //     }else {
        //         echo "Veuillez s'authentifier";
        //     }
        // }
        // if (isset($_POST['add'])) {
        //     $nomEvent = $_POST["nomEvent"];
        //     $typeEvent = $_POST["typeEvent"];
        //     $villeEvent = $_POST["villeEvent"];
        //     $dateDebut = $_POST["dateDebut"];
        //     $nbMax = $_POST["nbMax"];
        //     $tarif = $_POST["tarif"];
        //     $idOrganisateur = $_SESSION['id'];
        //     $Image = $_FILES['Image']['name'] ?? null;

        //     $imageFileType = strtolower(pathinfo($Image, PATHINFO_EXTENSION));
        //     $extensions_arr = array("jpg", "jpeg", "png", "gif");

        //     if (isset($_FILES['Image']) && !empty($_FILES['Image']['name'])) {
        //         if (in_array($imageFileType, $extensions_arr)) {
        //             $file_name = uniqid('', true) . '.' . $imageFileType;
        //             $target_path = $file_name;
        //             move_uploaded_file($_FILES['Image']['tmp_name'], 'C:\Users\YC\Documents\fil rouge\billeterie\src\assets' . $target_path);
        //             $event = new Event();
        //             $event->AddEvent($nomEvent, $typeEvent, $villeEvent, $dateDebut, $nbMax,$tarif,$idOrganisateur, $target_path);
        //             return $this->json(['message' => 'Post Added Successfully']);
        //         } else {
        //             return $this->json(['message' => 'Invalid File Type']);
        //         }
        //     } else {
        //         $postsModel = $this->model('FeedModel');
        //         $postsModel->updatePost($nomEvent, $typeEvent, $villeEvent, $dateDebut, $nbMax,$tarif,$idOrganisateur, null);
        //     }
        // }

        }


}
