$(document).ready(function(){
    var ajaxify = {
        
        target : '#ajaxify-content',
        block : '#ajaxify-block',
        
        links : '.ajaxify',
        
        // загружаем контент
        load : function(url){
            var that = this;
            $(ajaxify.target).load(
                url,
                function(){
                    that.next();
                });
        },
        
        // показываем информер (напр. загрузки)
        showInformer : function(text, type){
            $('<div>')
                .css({
                    'position' : 'absolute',
                    'right' : 0,
                    'top' : $('body').scrollTop(),
                    'width' : '100px',
                    'background' : 'green',
                    'color' : 'white',
                    'text-align' : 'center',
                    'margin-left' : '-50px'
                })
                .attr('id', 'ajaxify-informer')
                .text(text)
                .appendTo('body');
            this.next();
        },
        
        hideInformer : function(){
            $('#ajaxify-informer').remove();
            this.next();
        },
        
        open : function(){
            $(ajaxify.block)
                .css({
                    'top' : $('body').scrollTop()
                })
                .fadeIn();
            this.next();
        },
        
        close : function(){
            $(ajaxify.block).fadeOut();
        },
        
        init : function(){
            // добавляем и скрываем блок показывающий загруженный контент
            $('<div>')
                .attr('id', (ajaxify.block).substr(1))
                .appendTo('body')
                .hide()
                .css({
                    'position' : 'absolute',
                    'width' : '400px',
                    'padding' : '10px',
                    'left' : '50%',
                    'top' : $('body').scrollTop(),
                    'margin-top' : '30px',
                    'margin-left' : '-200px',
                    'background' : '#ffffdd',
                    'border' : '1px solid #0187C5'
                });
            
            // добавляем ссылку по клику на которую блок будет скрываться    
            $('<a>')
                .attr('href', '#')
                .attr('id', 'ajaxify-close')
                .appendTo(ajaxify.block)
                .text('закрыть')
                .css({
                    'float' : 'right'
                })
                .click(function(){
                    ajaxify.close();
                    return false;
                });
            // добавляем блок в который контент будет загружаться    
            $('<div>')
                .attr('id',(ajaxify.target).substr(1))
                .appendTo(ajaxify.block);
            
            
            // биндим ajax-загрузку контента на клик по ссылке с классом ajaxify
            $(this.links).click(function(){
                var url = $(this).attr('href');
                
                // создаем цепь событий
                var aj = new Chain();
                aj
                    .add(ajaxify.showInformer, ['loading...', 'info']) // показываем информкр
                    .add(ajaxify.load, [url]) //загружаем контент
                    .add(ajaxify.hideInformer) // убираем информер
                    .add(ajaxify.open) // показываем что загрузили
                    .go(); // включаем цепочку
                
                return false;    
            });
        }
    }
    
    ajaxify.init();
    
    // ссылки скрывающие/показывающие блок
    $('.toggle-block-link').each(function(){
        // находим id блока соответствующего данной ссылке
        var blockId = $(this).attr('id').substr(7);
        //скрываем его
        $('#' + blockId).hide();
        // при клике на ссылку показываем
        $(this).click(function(){
            $('#' + blockId).toggle();
        });
    });
});