$(document).ready(function() {

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

    $('.height input').on('keyup', function(ev){
        const $this = $(this);
        const height = $this.val();
        const rc_weight = Math.round(22*((height/100)**2));
        console.log(rc_weight);
        if (height.match(/^[0-9]+$/)){
        $(".recommendation-weight p").text("推奨体重：" + rc_weight + "kg");
        }
    })

});


