var sb233 = angular.module('sb233',['sb233.config','ngRoute']).config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.when(
'/',{templateUrl:'files.html'}
      ).when(
'/texts',{templateUrl:'texts.html'}
      )
     }]);
     
     angular.module('sb233.config',[]).constant('sb233config',{
    'APP_NAME': 'sb233',
    'APP_VERSION': '0.1',
    'TEXTJSONPATH': 'services/text/',

    'FILEJSONPATH': 'services/file/',
    'FILEDOWNPATH': 'files/',bgpath:'images/{0}.png'
,'filetemplate':'<div class="flinput"><input type="file" sb-change="flchange(fname)" name="file[]" /><span class="action del" ng-click="delfile($event)">del</span></div>'
  }).constant('sb233ids',{
page:'page',textname:'id',texttext:'text',uppp:'pp',responses:'responses',
  	error:'error233',data:'data233',entries:'entries',updel:'del',updparam:'update',uptext:'text',status:'status',msg:'msg'
  });
  var fileholderclassnos=['green','blue','darkpink','jade','lightgreen','mag','pink','red','yellow']
