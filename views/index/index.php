<?= $this->partial('common/header', $this) ?>
<h1>標準指令 Test:</h1>
<form id="form">
    <select id="list" name="id"></select>
    <div id="params"></div>
    <button type="submit">Submit</button>
</form>
<hr>
<h1>Result:</h1>
<pre id="result"></pre>
<script>
var commands;
$('#list').change(function(){
    var id = $(this).val();
    var command = commands[id];
    $('#params').html('');
    for (var param of command.params) {
        $('#params').append($('<input>').attr('name', 'params[]').attr('placeholder', param));
    }
});
$.get('/api/list', function(ret){ 
    $('#list').html('');
    commands = {};
    for (var command of ret.commands) {
        commands[command.id] = command;
        $('#list').append($('<option>').attr('value', command.id).text(command.name));
    }
    $('#list').change();
}, 'json');

$('#form').submit(function(e){
    e.preventDefault();
    var id = $('#list').val();
    api_url = '/api/query?id=' + encodeURIComponent(id);
    $('#params input').each(function(){
        api_url += '&params[]=' + encodeURIComponent($(this).val());
    });

    $.get(api_url, function(ret){
        $('#result').text(JSON.stringify(ret, null, 4));
    }, 'json');
});
</script>
<?= $this->partial('common/footer') ?>
