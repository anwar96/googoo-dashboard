$(function () {
    connectedUser();
    ignoreList();
    hitslist();
    newsong();

    setInterval(function() {
        connectedUser();
        ignoreList();
        hitslist();
        newsong();
    }, 60000);

    function ignoreList() {
        $.get('/api/ignore/list', function (r) {
            var source = $("#hb-ignore").html();
            var template = Handlebars.compile(source);
            $("#ignore-list").html(template(r)).slideDown('slow');
            //$("#text-reload-crowd").html('reload');
            $(".timeago").timeago();
            playlist();
        });
    }

    function playlist() {
        $("#text-reload-crowd").html('loading...');
        $.get('/api/playlist/', function (r) {
            var source = $("#hb-playlist").html();
            var template = Handlebars.compile(source);
            $("#playlist").html(template(r)).slideDown('slow');
            $("#text-reload-crowd").html('reload');
            $("#topgenre").html(r.genre);
            adlibs(r.genre);
        });
    }
    
    function hitslist(){
        $("#text-reload-hits").html('loading...');
        $.get('/api/hitslist/', function (r) {
            var source = $("#hb-hitslist").html();
            var template = Handlebars.compile(source);
            $("#hitslist").html(template(r)).slideDown('slow');
            $("#text-reload-hits").html('reload');
        });
    }
    
    function newsong(){
        $("#text-reload-new").html('loading...');
        $.get('/api/newsong/', function (r) {
            var source = $("#hb-newsong").html();
            var template = Handlebars.compile(source);
            $("#newsong").html(template(r)).slideDown('slow');
            $("#text-reload-new").html('reload');
        });
    }


    function connectedUser() {
        $("#text-reload-connected-user").html('loading...');
        var u = $("#current-program-name").attr('data-id');
        $.get('/api/listeners/' + u, function (r) {
            var source = $("#hb-listeners").html();
            var template = Handlebars.compile(source);
            $("#listeners-list").html(template(r)).slideDown('slow');
            $("#text-reload-connected-user").html('');
            $(".timeago").timeago();
        });
    }

    function adlibs(genre){
        $("#text-reload-adlibs").html('loading...');
        $.get('/api/adlibs/'+genre, function (r) {
            var source = $("#hb-adlibs").html();
            var template = Handlebars.compile(source);
            $("#adlibs").html(template(r)).slideDown('slow');
            $("#text-reload-adlibs").html('reload');
        });   
    }

    //change program
    $(".program-change").click(function () {
        var u = $(this).attr('href');
        $.get(u, function (r) {
            location.reload();
        });
        return false;
    });


    //reload connected user
    $("#btn-reload-connected-user").click(function () {
        connectedUser();
        return false;
    });

    //reload the playlist
    $("#btn-reload-crowd").click(playlist);
    
    //reload the hitslist
    $("#btn-reload-hits").click(hitslist);
    
    //reload the newsong
    $("#btn-reload-new").click(newsong);

    //ignore 
    $("#playlist").on('click', '.btn-ignore', function () {
        var id = $(this).attr('data-id');
        $.get('/api/ignore/' + id, function (r) {
            playlist();
            ignoreList();
        });

        return false;
    });
    
    //likedmember 
    $("#playlist").on('click', '.btn-liked-member', function () {
        var id = $(this).attr('data-id');
        $.get('/api/likedmember/' + id, function (r) {
            var source = $("#hb-likedmember").html();
            var template = Handlebars.compile(source);
            $("#likedMemberModal").html(template(r)).slideDown('slow');
            $('#likedMemberModal').modal('show');
        });

        return false;
    });
    
    //similarartist 
    $("#playlist").on('click', '.btn-similar-artist', function () {
        var id = $(this).attr('data-id');
        $.get('/api/similarartist/' + id, function (r) {
            var source = $("#hb-similarartist").html();
            var template = Handlebars.compile(source);
            $("#similarArtistModal").html(template(r)).slideDown('slow');
            $('#similarArtistModal').modal('show');
        });

        return false;
    });
    
    //similargenre 
    $("#playlist").on('click', '.btn-similar-genre', function () {
        var id = $(this).attr('data-id');
        var artist_id = $(this).attr('data-artist_id');
        $.get('/api/similargenre/' + id+'/artistid/'+artist_id, function (r) {
            var source = $("#hb-similargenre").html();
            var template = Handlebars.compile(source);
            $("#similarGenreModal").html(template(r)).slideDown('slow');
            $('#similarGenreModal').modal('show');
        });

        return false;
    });
    
    //similaryear 
    $("#playlist").on('click', '.btn-similar-year', function () {
        var year = $(this).attr('data-year');
        var artist_id = $(this).attr('data-artist_id');
        $.get('/api/similaryear/' + year+'/artistid/'+artist_id, function (r) {
            var source = $("#hb-similaryear").html();
            var template = Handlebars.compile(source);
            $("#similarYearModal").html(template(r)).slideDown('slow');
            $('#similarYearModal').modal('show');
        });

        return false;
    });


    //reload the ignore 
    $("#btn-reload-ignore").click(function () {
        ignoreList();
        return false;
    })


    // remove ignore action
    $("#ignore-list").on('click', '.btn-remove-ignore', function () {
        var id = $(this).attr('data-id');
        $.get('/api/ignore/' + id + '/remove', function (r) {
            playlist();
            ignoreList();
        });

        return false;
    });
    
    // removeall ignore action
    $("#btn-delete-ignore").on('click', function () {
        $.get('/api/ignore/removeall', function (r) {
            playlist();
            ignoreList();
        });

        return false;
    });

    //liked artist
    $("#listeners-list").on('click', '.btn-liked-member', function () {
        var id = $(this).attr('data-id');
        $.get('/api/likedartist/' + id, function (r) {
            var source = $("#hb-likedartist").html();
            var template = Handlebars.compile(source);
            $("#likedArtistModal").html(template(r)).slideDown('slow');
            $('#likedArtistModal').modal('show');
        });

        return false;
    });

    $("#adlibs").on('click', '.btn-click-adlibs', function () {
        var id = $(this).attr('data-id');
        $.get('/api/updateadlibs/' + id, function (r) {
            playlist();
        });

        return false; 
    });
});