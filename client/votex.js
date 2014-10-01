/**
 * Created by Vad1s0n
 * Date: 29.09.14
 * Time: 1:29
 * gitHub: https://github.com/vad1s0n/
 * Skype: keltus916
 */
(function($){
    $.fn.extend({
        Xresult: function(options) {
            var defaults = {
                url: '../server/vote.php'
            };

            var options = $.extend(defaults, options);

            return this.each(function() {
                var o =options;
                var obj = $(this);

                //get status
                $.ajax({
                    url: o.url ,
                    data: {action: "get_vote"},
                    method: "post",
                    dataType: "json"
                })
                .done(function( data ) {
                        obj.html("");
                        $.each(data, function(i, question) {
                            console.log(question);
                            var html = "<div class=\"voteX\"><span class='voteXtitle'>"+question.question_text+"</span>";

                            /*
                             * show results
                             */
                            if(question.type == "results") {
                                html = html + "<ul class='answers'>";
                                $.each(question.answers, function(j, answer) {
                                    html = html + "<li>"+answer.answer_text+"</li>";
                                    html = html + "<li class='bar'><div style='width:"+answer.count+"%;background: "+answer.color+"' class='fill'></div>";
                                    if(answer.type=="numbers") {
                                        html = html + "<span>"+answer.num+"</span></li>";
                                    }else{
                                        html = html + "<span>"+answer.count+"%</span></li>";
                                    }
                                });
                                html = html + "</ul>";
                            }

                            /*
                             * show poll
                             */
                            if(question.type == "vote") {
                                html = html + "<ul class='answers'>";
                                $.each(question.answers, function(j, answer) {
                                    html = html + "<li class='poll'><a href='#' class='vote' data-q='"+question.question_id+"' data-a='"+answer.answer_id+"'>"+answer.answer_text+"</a></li>";
                                });
                                html = html + "</ul>";
                            }

                            html = html + "</div>";

                            obj.append(html);

                            $(".poll .vote").click(function(){
                                var qid = $(this).data("q");
                                var aid = $(this).data("a");
                                $.ajax({
                                    url: o.url ,
                                    data: {action: "vote", q:qid,a:aid},
                                    method: "post",
                                    dataType: "json"
                                })
                                .done(function( data ) {
                                    if(typeof data.error === 'undefined') {
                                        if(data.msg=="ok") {
                                            obj.Xresult({url: o.url});
                                        }
                                    }else{
                                        //alert(data.error);
                                    }
                                });
                            });
                        });
                    });
            });
        }
    });
})(jQuery);
