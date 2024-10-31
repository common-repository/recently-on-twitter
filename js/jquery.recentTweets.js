/*
    
    name: recentTweets
    file: jquery.recentTweets.js
    author: gregory tomlinson
    copyright: (c) 2010 gregory tomlinson | gregory.tomlinson@gmail.com
    Dual licensed under the MIT and GPL licenses.
    ////////////////////////////////////
    ////////////////////////////////////
    dependencies: jQuery 1.3.2, jquery.timeFormat.js
    ////////////////////////////////////
    ////////////////////////////////////            

*/

(function($){
    
    $.fn.recentTweets = function( username, options ) {
        
        var el=this, o = $.extend(true, {}, defaults, options ), username = username || "gregory80", 
            regex_pattern  = '(https{0,1}:\/\/[^.]\.[^ ]{2,}|www\.[^.]+\.[^ ]{2,})',
            link_users_pattern = '(@[a-zA-Z0-9]{2,})',     
            hash_tag_pattern = '(#[a-zA-Z0-9]{2,})',         
            regex = new RegExp(regex_pattern, 'gi'),
            users_regex = new RegExp(link_users_pattern, 'gi'),
            hash_regex = new RegExp(hash_tag_pattern, 'gi');           
        
        o.url = o.url.replace(/\$username/gi, username )
        
        connector(o.url, o.params, success)
        
        return this;
        
        function success(jo) {
            var date, since, i=0, tweets=[], html;
            for( ; i<jo.length; i++) {
                date = new Date(Date.parse( jo[i].created_at ) ).getTime()
                since = $.timeFormat( date/1000 );
                
                html = '<li class="recentlyOnTwitterListItem" style="display:none;">'
                    html +=  '<div class="recentlyOnTwitterText">' + findLinks( jo[i].text ) + '</div>';
                    html += '<div class="recentlyOnTwitterDates sp_list_itm_span"><a href="http://twitter.com/'+username+'/status/'+ jo[i].id + '">' + since + '</a></div>'
                html += '</li>'

                tweets.push( html );
            }
            
            $tweets = $( tweets.join("") );
            $tweets.appendTo(el).fadeIn('normal');
            
            if(jo.length > 0 ) {
                el.trigger('recentTweetsLoaded', {tweets : jo, num : jo.length } )
            }
            
            
        }
        
        function findLinks( tweet ) {
            var username, tweet_text_linked = tweet.replace( regex, function($1) {
                return '<a href="'+$1+'">' + $1 + '</a>' 
            }).replace( users_regex, function($1) {
                username = $1.substring(1) 
                return '@<a href="http://twitter.com/'+username+'">' + username + '</a>' 
            }).replace(hash_regex, function($1) {
                return '<a href="http://twitter.com/search?q='+encodeURIComponent($1)+'">' + $1 + '</a>' 
            });
            return tweet_text_linked;
        }
    }
    
    var defaults = {
        url : 'http://api.twitter.com/1/statuses/user_timeline/$username.json',
        params : {
            count : 5,
            page : 1
        }
    }
    
    function connector(url, params, callback) {
        var str = $.param( params );
        $.ajax({
            dataType: 'jsonp',                    
            'url' : url, 
            data : str,
            traditional:true,
            success : callback
        });
    }
    
})(jQuery);