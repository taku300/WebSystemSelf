$(document).ready(function() {

    // 画像を選択したときに動的に表示
    $('.food-img-content input').on('change', function (ev) {

        //コンソールタブで適切に処理が動いているか確認
        console.log("image is changed");
    
        //このFileReaderが画像を読み込む上で大切
        const reader = new FileReader();
        //--ファイル名を取得
        // ev.targetがimput そのファイル名を取得
        // const fileName = ev.target.files[0].name;
    
        //--画像が読み込まれた時の動作を記述
        // target.result　imputの読み込み結果　　
        // HTMLの書き換え
        reader.onload = function (ev) {
            $('.submit-img img').attr('src', ev.target.result);
        }
        // readerクラスのメソッド
        // readAsDataURL(blob) – データを base64 データurl にエンコードします　　
        // データurl：小さなファイルをインラインで文書に埋め込むことができます
    
        reader.readAsDataURL(this.files[0]);
        //画像を文章に置き換えてそれを読み込むことでブラウザ上で埋め込みを可能にしている。
    })

    // 身長から推奨体重を計算
    $('.height input').on('keyup', function(ev){　//入力したとき
        const $this = $(this);
        const height = $this.val();
        const rc_weight = Math.round(22*((height/100)**2));
        console.log(rc_weight);
        if (height.match(/^[0-9]+$/)){
        $(".recommendation-weight p").text("推奨体重：" + rc_weight + "kg");
        }
    })

    $('div[id^="num"] input').on('keyup', function(ev){
        const $a = $('div[id^="num"] input').next().val();
        // const $this = $(this);
        // const height = $this.val();
        // const rc_weight = Math.round(22*((height/100)**2));
        console.log($a);
        // if (height.match(/^[0-9]+$/)){
        // $(".recommendation-weight p").text("推奨体重：" + rc_weight + "kg");
        // }
    })

    $('.like').on('click', function(e) {
        var e = e || window.event;
        var recipe = e.target || e.stcElement;
        var recipe_id = recipe.id;
        var $add_like = $('.like-' + recipe_id);
        var $add_like = $('.like-' + recipe_id);
        var $likes_count = $('.likes-count-' + recipe_id);
        
        
        //ajax処理スタート
        $.ajax({
            headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
            url: '/like', //通信先アドレスで、このURLをあとでルートで設定します
            method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
            data: { //サーバーに送信するデータ
                'recipe_id': recipe_id //いいねされた投稿のidを送る
            },
            })
            //通信成功した時の処理
            .done(function (data) {
            $add_like.toggleClass('pink'); //likedクラスのON/OFF切り替え。
            $likes_count.html(data.likes_count);
            })
            //通信失敗した時の処理
            .fail(function () {
            console.log('fail'); 
            });
    });

});


