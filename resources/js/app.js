import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

///var channel = Echo.privet(`App.Models.User,${userID}`);         //defult channel=>public
//channel.Notification(function(data) {                    //listen lliurmint\app\event...
 //console.log(data);
 //alert(data.body);
    // alert(JSON.stringify(data));
//});
Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        console.log(notification);
    });