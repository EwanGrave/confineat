<?php
require_once("front_controller.php");
require_once("back_controller.php");

final class Index{
    public static function API() : void{
        if (isset($_GET["action"]) && !empty($_GET["action"])){

            switch ($_GET["action"]){
                case "login":
                    FrontController::getLoginPage();
                    break;

                case "register":
                    FrontController::getRegisterPage();
                    break;
                
                case "auth":
                    BackController::setAuthentication();
                    break;

                case "signin":
                    BackController::setRegistration();
                    break;
                
                case "logout":
                    BackController::setLogout();
                    break;

                case "compte":
                    FrontController::getAccountPage();
                    break;

                case "menus":
                    FrontController::getMenuPage();
                    break;

                case "desserts":
                    FrontController::getDessertsPage();
                    break;

                case "boissons":
                    FrontController::getBoissonsPage();
                    break;

                case "plats":
                    FrontController::getPlatsPage();
                    break;
                
                case "burgers":
                    FrontController::getBurgersPage();
                    break;

                case "paninis":
                    FrontController::getPaninisPage();
                    break;

                case "salades":
                    FrontController::getSaladesPage();
                    break;

                case "sandwichs":
                    FrontController::getSandwichsPage();
                    break;

                case "basket":
                    FrontController::getBasketPage();
                    break;
                
                case "removeItem":
                    BackController::removeItem();
                    break;
                
                case "addItem":
                    BackController::addItem();
                    break;

                case "addMenu":
                    BackController::addMenu();
                    break;

                case "updateAccount":
                    FrontController::updateAccount();
                    break;
                
                case "setUpdate":
                    BackController::setUpdate();
                    break;
                
                case "order":
                    FrontController::getOrderPage();
                    break;

                case "sendOrder":
                    BackController::sendOrder();
                    break;
                
                case "recupQuantityDatas":
                    BackController::recupQuantityDatas();
                    break;

                case "Menu Etudiant":
                    FrontController::getPersoMenuPage(7);
                    break;
            
                case "Menu Duo":
                    FrontController::getPersoMenuPage(8);
                    break;
                
                case "Menu Full":
                    FrontController::getPersoMenuPage(9);
                    break;
                
                case "Menu Salade":
                    FrontController::getPersoMenuPage(10);
                    break;
                
                case "Menu Light":
                    FrontController::getPersoMenuPage(11);
                    break;
                
                case "Menu Burger":
                    FrontController::getPersoMenuPage(12);
                    break;

                case "delivery":
                    FrontController::getDeliveryPage();
                    break;

                case "aboutus":
                    FrontController::getAboutusPage();
                    break;
                
                case "policy":
                    FrontController::getPolicyPage();
                    break;

                case "articles":
                    FrontController::getArticlesPage();
                    break;

                case "setquantity":
                    BackController::setQuantity();
                    break;

                case "orders":
                    FrontController::getOrdersPage();
                    break;

                case "delivered":
                    BackController::setDeliveryStatus();
                    break;

                case "deleteFromSessionSupply":
                    BackController::deleteFromSessionSupply();
                    break;
                
                case "historical":
                    FrontController::getHistoricalPage();
                    break;

                case "Supprimer_Utilisateur":
                    BackController::DeleteAllUserDatas(3);
                    break;

                default:
                    FrontController::getHomePage();
                    break;
            }

        }else{
            FrontController::getHomePage();
        }
    }
}

Index::API();