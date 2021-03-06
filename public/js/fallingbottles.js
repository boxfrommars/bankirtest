$(document).ready(function(){
    var bottleWidth = 100;
    
    // расставляем бутылки
    $('.filled-bottle').each(function(i){
        $(this).css('left', (i + 1)*bottleWidth + 'px');
    });
    
    // считаем бутылки
    var bottlesCount = $('.filled-bottle').length;
    
    // первая бутылка падает
    var fall = function(){
        var that = this;
        $('.on-table').eq(0).animate({ top: 400}, 2000, function(){
            $(this).removeClass('on-table').html('').addClass('debris');
            bottlesCount = $('.on-table').length;
            that.next();
        });
    }
    
    // сдвигаем бутылки влево
    var shiftLeft = function(){
        var that = this;
        $('.on-table').each(function(i){
            $(this).animate({ left: $(this).position().left - bottleWidth}, 1000, function(){
                // если сдвинутая бутылка последняя, то переходим к следующему событию цепи
                (i + 1 == bottlesCount) ? that.next() : false;
            });
        });
    }
    var getSongText = function(count, type){
        if (type == 'lying') return "одна бутылка упала";
        if (count > 4) return count + " бутылок стояло на столе";
        if (count > 1) return count + " бутылки стояли на столе";
        if (count == 1) return count + " бутылка стояла на столе";
        return "и нет больше бутылок на столе :(";
    } 
    // показываем строчку из песни
    var showSongLine = function(type){
        var that = this;
        var text = getSongText(bottlesCount, type);
        $('#songline').show().text(text);
        that.next();
    }
    
    // цепь событий
    var FallChain = new Chain();
    FallChain.add(showSongLine);
    for (var i = 0; i < bottlesCount; i++){
        FallChain
            .add(showSongLine, ['staying'])
            .add(shiftLeft)
            .add(showSongLine, ['lying'])
            .add(fall);
    }
    FallChain.add(showSongLine, ['staying']);
    $('#sing-song').click(function(){
        FallChain.unblock();
        FallChain.go();
    });
    $('#stop-song').click(function(){
        FallChain.block();
    });
});