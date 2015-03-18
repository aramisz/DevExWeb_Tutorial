/**
 * Created by Aramisz on 2014.05.29..
 */
'use strict'

app.directive('asImg', function () {
    return {
        restrict: 'E',
        scope: '@',
        template: '<img>',
        replace: true,
        link: function (iScope, iElement, iAttrs) {
            var src = iAttrs.src;
            var src_hover = iAttrs.srcHover;
            var active = iAttrs.active;
            var active = angular.isDefined(active) && active != 'false' ? true : false;

            iElement.on('mouseover click', function () {
                iElement.attr('src', src_hover);
            });

            iElement.on('mouseout', function () {
                if (!active) {
                    iElement.attr('src', src);
                }
            });

            if (active) {
                iElement.attr('src', src_hover);
            }
        }
    }
});

app.directive('asImageHover', function () {
    return {
        restrict: 'A',
        scope: '@',
        template: '<img>',
        replace: true,
        link: function (iScope, iElement, iAttrs) {
            var src = iAttrs.src;
            var src_hover = iAttrs.asImageHover;
            var active = iAttrs.active;
            var active = angular.isDefined(active) && active != 'false' ? true : false;

            iElement.on('mouseover click', function () {
                iElement.attr('src', src_hover);
            });

            iElement.on('mouseout', function () {
                if (!active) {
                    iElement.attr('src', src);
                }
            });

            if (active) {
                iElement.attr('src', src_hover);
            }
        }
    }
});
