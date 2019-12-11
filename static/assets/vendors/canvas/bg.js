/* 
 * @Author: YDKD
 * @Date:   2019-09-20 09:24:15
 * @Last Modified by:   YDKD
 * @Last Modified time: 2019-09-25 14:39:42
 */

'use strict';
$(document).ready(function() {
    var stars = 1000; /*星星的密集程度，数字越大越多*/
    var $stars = $(".stars");
    var r = 1000; /*星星的看起来的距离,值越大越远,可自行调制到自己满意的样子*/
    for (var i = 0; i < stars; i++) {
        var $star = $("<div/>").addClass("star");
        $stars.append($star);
    }
    $(".star").each(function() {
        var cur = $(this);
        var s = 0.2 + (Math.random() * 1);
        var curR = r + (Math.random() * 300);
        cur.css({
            transformOrigin: "0 0 " + curR + "px",
            transform: " translate3d(0,0,-" + curR + "px) rotateY(" + (Math.random() * 360) + "deg) rotateX(" + (Math.random() * -50) + "deg) scale(" + s + "," + s + ")"

        })
    })
})