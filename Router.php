<? php
namespace Library ;

 class Router
{
protected $routes = array () ;

const NO_ROUTE = 1 ;

 public function addRoute ( Route $route )
 {
 if (! in_array ( $route , $this - > routes ) )
 {
 $this - > routes [] = $route ;
 }
 }

 public function getRoute ( $url )
 {
 foreach ( $this - > routes as $route )
 {
 // Si la route correspond à l 'URL .
 if (( $varsValues = $route - > match ( $url ) ) !== false )
 {
// Si elle a des variables .


 if ( $route - > hasVars () )
 {
 $varsNames = $route - > varsNames () ;
 $listVars = array () ;

 // On créé un nouveau tableau clé/ valeur .
 // (Clé = nom de la variable , valeur = sa valeur .)
 foreach ( $varsValues as $key = > $match )
 {
 // La premi ère valeur contient enti è rement la
chaine captur ée ( voir la doc sur preg_match ).
 if ( $key !== 0 )
 {
 $listVars [ $varsNames [ $key - 1 ]] = $match ;
 }
 }

 // On assigne ce tableau de variables à la route .
 $route - > setVars ( $listVars );
 }

 return $route ;
 }
 }

 throw new \ RuntimeException ( 'Aucune route ne correspond à l\' URL ', self :: NO_ROUTE ) ;
 }
 }
