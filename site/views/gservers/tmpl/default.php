<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<h1>Game Server overview</h1>
<table id='game_server_table'><tr><td>Loading...</td></tr></table>
<script type='text/javascript'>
var gservers_filter = "<?php echo htmlspecialchars($this->param_servertype); ?>";
var gservers_lastsort = "";
var gservers_inverse = false;
function gservers_getList(sorting) {
    
    // Handle sorting
    if(gservers_lastsort == sorting) {
        if(gservers_inverse) gservers_inverse = false;
        else gservers_inverse = true;
    } else gservers_inverse = false;
    gservers_lastsort = sorting;
    
    // Fetch data
    var request = new Request({
        'url': "/api/gservers_json.php?sorting=" + sorting + "&filter=" + gservers_filter,
        'method': "post",
        'data': {},
        'async': true,
        'onSuccess': function(resp){
            if(resp.substr(0, 8) == "SUCCESS:") {
                resp = JSON.parse(resp.substr(8));
                var html = "";
                html += "<tr>\n";
                html += "    <th onclick='gservers_getList(\"status\")' style='cursor: pointer'>Status</th>\n";
                html += "    <th onclick='gservers_getList(\"game\")' style='cursor: pointer'>Game</th>\n";
                html += "    <th onclick='gservers_getList(\"name\")' style='cursor: pointer'>Name</th>\n";
                html += "    <th onclick='gservers_getList(\"map\")' style='cursor: pointer'>Current Map</th>\n";
                html += "    <th onclick='gservers_getList(\"players\")' style='cursor: pointer'>Players</th>\n";
                html += "    <th>Connect</th>\n";
                html += "</tr>";
                
                if(gservers_inverse) for(var i = resp.length - 1; i >= 0; i--) html += gservers_makerow(resp[i]);
                else for(var i = 0; i < resp.length; i++) html += gservers_makerow(resp[i]);
                document.getElementById('game_server_table').innerHTML = html;
            } else {
                document.getElementById('game_server_table').innerHTML = "<tr><td>Error loading listing!</td><td>" + resp + "</td></tr>\n";
            }
        }
    }).send();
}

// Output row
function gservers_makerow(data) {
    var status = "online";
    if(data.restartsend != "no") status = "offline";
    if(data.goingdown != "no") status = "offline";
    html = "<tr>\n";
    html += "    <td>" + status + "</td>\n";
    html += "    <td>" + data.type + "</td>\n";
    html += "    <td>" + data.servername + "</td>\n";
    html += "    <td>" + data.currentmap + "</td>\n";
    html += "    <td>" + parseInt(data.currentplayers, 10) + " / " + parseInt(data.maxplayers, 10) + "</td>\n";
    html += "    <td><a href='steam://connect/" + data.ip + ":" + data.port + "'>Connect</a></td>\n";
    html += "</tr>";
    return html;
}

// Init
gservers_getList("");
</script>
