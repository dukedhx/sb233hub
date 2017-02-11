var sb233=angular.module('sb233.config',[]).constant('sb233config',{
    'APP_NAME': 'sb233',
    'APP_VERSION': '0.1',
    'TEXTJSONPATH': 'services/text.php',
    'USERJSONPATH': 'services/user.php',

    'FILEJSONPATH': 'services/file.php',
    'FILEDOWNPATH': 'files/',bgpath:'images/{0}.png'
  }).constant('sb233ids',{user:'user',
page:'page',textname:'id',texttext:'text',uppp:'pp',responses:'responses',pwparam:'pw',usrparam:'usr',roleparam:'role',
  	error:'error233',data:'data233',entries:'entries',updel:'del',updparam:'update',uptext:'text',status:'status',msg:'msg'
  });

var fileholderclassnos=['green','blue','darkpink','jade','lightgreen','mag','pink','red','yellow'],sb233 = angular.module('sb233',['sb233.config','ngRoute']).config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.when(
'/',{templateUrl:'files.html'}
      ).when(
'/texts',{templateUrl:'texts.html'}
      )
     }])
     
     var fileholderclassnos=['green','blue','darkpink','jade','lightgreen','mag','pink','red','yellow']
