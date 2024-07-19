(function($) {
    $.fn.SocialCounter = function(options) {
        var settings = $.extend({
            // These are the defaults.
            instagram_user:'',
            instagram_user_sandbox:'',
            instagram_token:'',
            youtube_user:'',
            youtube_key:'',
            pinterest_user:'',
            soundcloud_user_id:'',
            soundcloud_client_id:'',
            vimeo_user:'',
            vimeo_token:'',
            github_user:'',
            behance_user:'',
            behance_client_id:'',
            vk_id:'',
        }, options);

        function pinterest(){
            //Pinterst API V3
            $.ajax({
                url: 'https://api.pinterest.com/v3/pidgets/users/'+settings.pinterest_user+'/pins',
                dataType: 'jsonp',
                type: 'GET',
                success: function(data) {
                    var followers = parseInt(data.data.user.follower_count);
                    var k = kFormatter(followers);
                    $('#wrapper .item.pinterest .count').append(k);
                    $('#wrapper .item.pinterest').attr('href','https://pinterest.com/'+settings.pinterest_user);
                }
            });
        }
        function instagram(){
            //Create access tokens
            //https://www.youtube.com/watch?v=LkuJtIcXR68
            //http://instagram.pixelunion.net
            //http://dmolsen.com/2013/04/05/generating-access-tokens-for-instagram
            //http://ka.lpe.sh/2015/12/24/this-request-requires-scope-public_content-but-this-access-token-is-not-authorized-with-this-scope/
            $.ajax({
                url: 'https://api.instagram.com/v1/users/self/',
                dataType: 'jsonp',
                type: 'GET',
                data: {
                    access_token: settings.instagram_token
                },
                success: function(data) {
                    var followers = parseInt(data.data.counts.followed_by);
                    var k = kFormatter(followers);
                    $('#wrapper .item.instagram .count').append(k);
                    $('#wrapper .item.instagram').attr('href','https://instagram.com/'+settings.instagram_user);
                }
            });
        }
        function youtube(){
            //YouTube API V3
            $.ajax({
                url: 'https://www.googleapis.com/youtube/v3/channels',
                dataType: 'jsonp',
                type: 'GET',
                data:{
                    part:'statistics',
                    forUsername:settings.youtube_user,
                    key: settings.youtube_key
                },
                success: function(data) {
                    var subscribers = parseInt(data.items[0].statistics.subscriberCount);
                    var k = kFormatter(subscribers);
                    $('#wrapper .item.youtube .count').append(k);
                    $('#wrapper .item.youtube').attr('href','https://youtube.com/'+settings.youtube_user);
                }
            });
        }
        function soundcloud(){
            //SoundCloud API
            $.ajax({
                url: 'http://api.soundcloud.com/users/'+settings.soundcloud_user_id,
                dataType: 'json',
                type: 'GET',
                data:{
                    client_id: settings.soundcloud_client_id
                },
                success: function(data) {
                    var followers = parseInt(data.followers_count);
                    var k = kFormatter(followers);
                    $('#wrapper .item.soundcloud .count').append(k);
                    $('#wrapper .item.soundcloud').attr('href',data.permalink_url);
                }
            });
        }
        function vimeo(){
            //Vimeo V3 API
            $.ajax({
                url: 'https://api.vimeo.com/users/'+settings.vimeo_user+'/followers',
                dataType: 'json',
                type: 'GET',
                data:{
                    access_token: settings.vimeo_token
                },
                success: function(data) {
                    var followers = parseInt(data.total);
                    $('#wrapper .item.vimeo .count').append(followers).digits();
                    $('#wrapper .item.vimeo').attr('href','https://vimeo.com/'+settings.vimeo_user);
                }
            });
        }

        function github(){
            //Github
            $.ajax({
                url: 'https://api.github.com/users/'+settings.github_user,
                dataType: 'json',
                type: 'GET',
                success: function(data) {
                    var followers = parseInt(data.followers);
                    var k = kFormatter(followers);
                    $('#wrapper .item.github .count').append(k);
                    $('#wrapper .item.github').attr('href','https://github.com/'+settings.github_user);
                }
            });
        }
        function behance(){
            //Behance
            $.ajax({
                url: 'https://api.behance.net/v2/users/'+settings.behance_user,
                dataType: 'jsonp',
                type: 'GET',
                data:{
                    client_id: settings.behance_client_id
                },
                success: function(data) {
                    var followers = parseInt(data.user.stats.followers);
                    var k = kFormatter(followers);
                    $('#wrapper .item.behance .count').append(k);
                    $('#wrapper .item.behance').attr('href','https://behance.net/'+settings.behance_user);
                }
            });
        }
        //Function to add commas to the thousandths
        $.fn.digits = function(){
            return this.each(function(){
                $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
            })
        }
        //Function to add K to thousands
        function kFormatter(num) {
            return num > 999 ? (num/1000).toFixed(1) + 'k' : num;
        }

        function linkClick(){
            $('#wrapper .item').attr('target','_blank');
        }

        //Add oading effect
        setTimeout(function(){
            $('.main-social-counter').removeClass('hidden').addClass('load');
            $('.social-counter-loader').addClass('removed');
        },3000);
        linkClick();

        //Call Functions
        if(settings.instagram_user!='' && settings.instagram_token!=''){
            instagram();
        } if(settings.instagram_user_sandbox!='' && settings.instagram_token!=''){
            instagram_sandbox();
        } if(settings.youtube_user!='' && settings.youtube_key!=''){
            youtube();
        } if(settings.pinterest_user!=''){
            pinterest();
        } if(settings.soundcloud_user_id!='' && settings.soundcloud_client_id!=''){
            soundcloud();
        } if(settings.vimeo_user!='' && settings.vimeo_token!=''){
            vimeo();
        } if(settings.github_user!=''){
            github();
        } if(settings.behance_user!='' && settings.behance_client_id!=''){
            behance();
        }
    };
    
    

    
    
}(jQuery));