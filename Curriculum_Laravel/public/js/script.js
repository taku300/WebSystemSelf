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

    // いいね機能
    $(document).on('click','.like', function(e) {
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
            cache: false,
            timeout: 10000,
            data: { //サーバーに送信するデータ
                'recipe_id': recipe_id //いいねされた投稿のidを送る
            },
            })
            //通信成功した時の処理
            .done(function (data) {
            console.log(data);
            $add_like.toggleClass('pink'); //likedクラスのON/OFF切り替え。
            $likes_count.html(data.likes_count);
            })
            //通信失敗した時の処理
            .fail(function () {
            console.log('fail'); 
            });
    });        
        
        // グラムを入力すると変換
        $(document).on('keyup','.change4',function(e){
            var e = e || window.event;
            var food = e.target || e.stcElement;
            var food_id = food.dataset.id;
            var carbohydrate = food.dataset.carbohydrate;
            var protain = food.dataset.protain;
            var fat = food.dataset.fat;
            var general_weight = food.dataset.general_weight;
            var energy = carbohydrate * 4 + protain * 4 + fat * 9;
            var $energy_id = $('#energy-' + food_id);
            var $carbohydrate_id = $('#carbohydrate-' + food_id);
            var $protain_id = $('#protain-' + food_id);
            var $fat_id = $('#fat-' + food_id);
            var $gram = $('#amount-text-' + food_id);
            var $num = $('#num-text-' + food_id);
            var $num_change = $('#num-change-' + food_id);
            var $amount_change = $('#amount-change-' + food_id);
            var $num_box = $('#num-box-' + food_id);
            var $amount_box = $('#amount-box-' + food_id);
            var g = Number($gram.val());   
            if ($.isNumeric(g)){
                var energy_change = Math.round((energy * g / 100)*10)/10;
                var carbohydrate_change = Math.round((carbohydrate * g / 100)*10)/10;
                var protain_change = Math.round((protain * g / 100)*10)/10;
                var fat_change = Math.round((fat * g / 100)*10)/10;
                $energy_id.text(energy_change + 'kcal');
                $carbohydrate_id.text(carbohydrate_change + 'g');
                $protain_id.text(protain_change + 'g');
                $fat_id.text(fat_change + 'g');
            }
        });
        // gを入力すると変換
        $(document).on("keyup",'.change2',function(e){
            var e = e || window.event;
            var food = e.target || e.stcElement;
            var food_id = food.dataset.id;
            var carbohydrate = food.dataset.carbohydrate;
            var protain = food.dataset.protain;
            var fat = food.dataset.fat;
            var general_weight = food.dataset.general_weight;
            var energy = carbohydrate * 4 + protain * 4 + fat * 9;
            var $energy_id = $('#energy-' + food_id);
            var $carbohydrate_id = $('#carbohydrate-' + food_id);
            var $protain_id = $('#protain-' + food_id);
            var $fat_id = $('#fat-' + food_id);
            var $gram = $('#amount_text-' + food_id);
            var $num = $('#num-text-' + food_id);
            var $num_change = $('#num-change-' + food_id);
            var $amount_change = $('#amount-change-' + food_id);
            var $num_box = $('#num-box-' + food_id);
            var $amount_box = $('#amount-box-' + food_id);
            var n = Number($num.val()); 
            if ($.isNumeric(n)){
            var energy_change = Math.round(energy * general_weight / 100 * n, 1);
            var carbohydrate_change = Math.round(carbohydrate * general_weight / 100 * n, 1);
            var protain_change = Math.round(protain * general_weight / 100 * n, 1);
            var fat_change = Math.round(fat * general_weight / 100 * n, 1);
            $energy_id.text(energy_change + 'kcal');
            $carbohydrate_id.text(carbohydrate_change + 'g');
            $protain_id.text(protain_change + 'g');
            $fat_id.text(fat_change + 'g');
            }
        });
        // gで指定ボタン
        $(document).on('click','.change1',function(e){
            var e = e || window.event;
        var food = e.target || e.stcElement;
        var food_id = food.dataset.id;
        var carbohydrate = food.dataset.carbohydrate;
        var protain = food.dataset.protain;
        var fat = food.dataset.fat;
        var general_weight = food.dataset.general_weight;
        var energy = carbohydrate * 4 + protain * 4 + fat * 9;
        var $energy_id = $('#energy-' + food_id);
        var $carbohydrate_id = $('#carbohydrate-' + food_id);
        var $protain_id = $('#protain-' + food_id);
        var $fat_id = $('#fat-' + food_id);
        var $gram = $('#amount-text-' + food_id);
        var $num = $('#num-text-' + food_id);
        var $amount_change = $('#amount-change-' + food_id);
        var $num_box = $('#num-box-' + food_id);
        var $amount_box = $('#amount-box-' + food_id);
            $amount_box.removeClass('d-none');
            $num_box.addClass('d-none');
            $gram.val(100);
            $num.val(null);
            $energy_id.text(energy + 'kcal');
            $carbohydrate_id.text(carbohydrate + 'g');
            $protain_id.text(protain + 'g');
            $fat_id.text(fat + 'g');
        });
        // 個数で指定ボタン
        $(document).on('click','.change3',function(e){
            var e = e || window.event;
            var food = e.target || e.stcElement;
            var food_id = food.dataset.id;
            var carbohydrate = food.dataset.carbohydrate;
            var protain = food.dataset.protain;
            var fat = food.dataset.fat;
            var general_weight = food.dataset.general_weight;
            var energy = carbohydrate * 4 + protain * 4 + fat * 9;
            var $energy_id = $('#energy-' + food_id);
            var $carbohydrate_id = $('#carbohydrate-' + food_id);
            var $protain_id = $('#protain-' + food_id);
            var $fat_id = $('#fat-' + food_id);
            var $gram = $('#amount-text-' + food_id);
            var $num = $('#num-text-' + food_id);
            var $num_change = $('#num-change-' + food_id);
            var $num_box = $('#num-box-' + food_id);
            var $amount_box = $('#amount-box-' + food_id);
            $num_box.removeClass('d-none');
            $amount_box.addClass('d-none');
            var energy_num = Math.round((energy * general_weight / 100)*10)/10;
            var carbohydrate_num = Math.round((carbohydrate * general_weight / 100)*10)/10;
            var protain_num = Math.round((protain * general_weight / 100)*10)/10;
            var fat_num = Math.round((fat * general_weight / 100)*10)/10;
            $gram.val(null);
            $num.val(1);
            $energy_id.text(energy_num + 'kcal')
            $carbohydrate_id.text(carbohydrate_num + 'g')
            $protain_id.text(protain_num + 'g')
            $fat_id.text(fat_num + 'g')
            
        });

    // 食材無限スクロール
    // スクロールされた時に実行
$(window).on("scroll", function () {
    　　// スクロール位置
        // ブラウザ全体の高さ
        var document_h = $(document).height(); 
        //ウィンドウのトップから表示領域の一番下までの高さ          
        var window_h = $(window).height() + $(window).scrollTop(); 
        //後どれくらいスクロールできるか   
        var scroll_pos = (document_h - window_h) ;  
        var url = location.pathname;
        console.log(url);
        // 画面最下部にスクロールされている場合
        if (scroll_pos <= 1) {
            // ajaxコンテンツ追加処理
            if(url == '/administrator' || url == '/registers' || url.indexOf('/recipe/edit/') != -1){
                ajaxAddContentFood();
            }
            if(url == '/recipe' || url == '/record/register'){
                ajaxAddContentRecipe();
            }
        }
    });
     
    // Foodコンテンツ追加処理
    function ajaxAddContentFood() {
        // 追加コンテンツ
        var add_content = "";
        // コンテンツ件数           
        var count =  parseInt($("#count").val());
        //URLのパラメータ取得
        var keyword = $('#keyword').val(); 
        var clear = $('#clear').val();
        var category_id = $('#category_id').val();
        var recipe_id = $('#recipe_id').val();
        // ajax処理
        $.ajax({
            headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
            url: '/addfood', //通信先アドレスで、このURLをあとでルートで設定します
            method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
            datatype: "json",
            data: { //サーバーに送信するデータ
                'count' : count,
                'keyword' : keyword,
                'clear' : clear,
                'category_id' : category_id
            },
            })
            //通信成功した時の処理
            .done(function (data) {
                // 管理者画面に食材を追加
                $.each(data.foods,function(key,food){
                    var energy= food.carbohydrate * 4 + food.protain * 4 + food.fat * 9;
                    $("#foods").append(`\
                    <div class="food">\
                        <div class="food-main">\
                            <div class="food-image">\
                                <img src="/${food.image}" alt="" class="">\
                            </div>\
                            <div class="food-info">\
                                <div class="info-container">\
                                    <div class="mb-2 hide">\
                                        ${food.name} \
                                    </div>\
                                    <p class="hide">100gあたり(1 ${food.unit} ${food.general_weight } g )</p>\
                                        <table class="food-table">\
                                            <tr class="text-right">\
                                                <td height="1rem" width="68">エネルギー：</td>\
                                                <td>${energy}kcal</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td height="1rem" width="68">炭水化物：</td>\
                                                <td>${food.carbohydrate}g</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td width="68">タンパク質：</td>\
                                                <td>${food.protain}g</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td width="68">脂質：</td>\
                                                <td>${food.fat}}g</td>\
                                            </tr>\
                                        </table>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="food-submit">\
                            <a href="/food/edit/${food.id}">編集</a>\
                            <a href="/food/destory/${food.id}">消去</a>\
                        </div>\
                    </div>\
                    `);
                    
                })
                // 登録画面に食材を追加
                $.each(data.foods,function(key,food){
                    var energy= Math.round(food.carbohydrate * 4 + food.protain * 4 + food.fat * 9, 1);
                    $("#register-foods").append(`\
                    <form action="/add_food/${food.id}" method="get">\
                        <div class="food-item">\
                            <div class="food-main">\
                                <div class="food-image recipe-image">\
                                    <img src="/${food.image}" alt="" class="">\
                                </div>\
                                <div class="food-info recipe-info">\
                                    <div class="info-container">\
                                        <div class="mb-2 hide">\
                                            ${food.name} \
                                        </div>\
                                        <p class="hide">100gあたり(1 ${food.unit} ${food.general_weight } g )</p>\
                                        <table class="food-table">\
                                            <tr class="text-right">\
                                                <td height="1rem" width="68">エネルギー：</td>\
                                                <td id="${'energy-' + food.id}">${energy}kcal</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td height="1rem" width="68">炭水化物：</td>\
                                                <td id="${'carbohydrate-' + food.id}">${food.carbohydrate}g</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td width="68">タンパク質：</td>\
                                                <td id="${'protain-' + food.id}">${food.protain}g</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td width="68">脂質：</td>\
                                                <td id="${'fat-' + food.id}">${food.fat}}g</td>\
                                            </tr>\
                                        </table>\
                                    </div>\
                                </div>\
                                <div class="amount-boxes">\
                                    <form onsubmit="return false;"> \
                                        <input type="hidden" value="100" id="${'data-' + food.id}" >\
                                        <div id= "${'num-box-' + food.id }" class = "d-none">\
                                            <input type="button" value="gで指定" name='num' class="change1 num" id = "${'num-change-' + food.id }" data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                            <div class="recipe-text-box" id = "${'num-' + food.id}">\
                                                <input type="text" name ="${'num-' + food.id}" class="change2 num-text " id = "${'num-text-' + food.id}" data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                                <p class = "">${food.unit}</p>\
                                            </div>\
                                        </div>\
                                        <div id = "${'amount-box-' + food.id}" class="">\
                                            <input type="button" value="個数で指定" name='amount' class="change3 amount" id = "${'amount-change-' + food.id}" data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                            <div class="recipe-text-box" id = "${'amount-' + food.id}">\
                                                <input type="text" name ="${'amount-' + food.id}" class = "change4 amount-text" id = "${'amount-text-' + food.id}" value=100 data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                                <p>g</p>\
                                            </div>\
                                        </div>\
                                    </form>\
                                </div>\
                            </div>\
                            <div class="food-submit">\
                                <button type="submit" class="btn search-btn">＋</button>\
                            </div>\
                        </div>\
                    </form>
                    `);
                    
                })

                // 登録編集画面に食材を追加
                $.each(data.foods,function(key,food){
                    var energy= Math.round(food.carbohydrate * 4 + food.protain * 4 + food.fat * 9, 1);
                    $("#edit-foods").append(`\
                    <form action="/add_food/edit/${recipe_id}/${food.id}" method="get">\
                        <div class="food-item">\
                            <div class="food-main">\
                                <div class="food-image recipe-image">\
                                    <img src="/${food.image}" alt="" class="">\
                                </div>\
                                <div class="food-info recipe-info">\
                                    <div class="info-container">\
                                        <div class="mb-2 hide">\
                                            ${food.name} \
                                        </div>\
                                        <p class="hide">100gあたり(1 ${food.unit} ${food.general_weight } g )</p>\
                                        <table class="food-table">\
                                            <tr class="text-right">\
                                                <td height="1rem" width="68">エネルギー：</td>\
                                                <td id="${'energy-' + food.id}">${energy}kcal</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td height="1rem" width="68">炭水化物：</td>\
                                                <td id="${'carbohydrate-' + food.id}">${food.carbohydrate}g</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td width="68">タンパク質：</td>\
                                                <td id="${'protain-' + food.id}">${food.protain}g</td>\
                                            </tr>\
                                            <tr class="text-right">\
                                                <td width="68">脂質：</td>\
                                                <td id="${'fat-' + food.id}">${food.fat}g</td>\
                                            </tr>\
                                        </table>\
                                    </div>\
                                </div>\
                                <div class="amount-boxes">\
                                    <form onsubmit="return false;"> \
                                        <input type="hidden" value="100" id="${'data-' + food.id}" >\
                                        <div id= "${'num-box-' + food.id }" class = "d-none">\
                                            <input type="button" value="gで指定" name='num' class="change1 num" id = "${'num-change-' + food.id }" data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                            <div class="recipe-text-box" id = "${'num-' + food.id}">\
                                                <input type="text" name ="${'num-' + food.id}" class="change2 num-text " id = "${'num-text-' + food.id}" data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                                <p class = "">${food.unit}</p>\
                                            </div>\
                                        </div>\
                                        <div id = "${'amount-box-' + food.id}" class="">\
                                            <input type="button" value="個数で指定" name='amount' class="change3 amount" id = "${'amount-change-' + food.id}" data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                            <div class="recipe-text-box" id = "${'amount-' + food.id}">\
                                                <input type="text" name ="${'amount-' + food.id}" class = "change4 amount-text" id = "${'amount-text-' + food.id}" value=100 data-id="${food.id}" data-carbohydrate="${food.carbohydrate}" data-protain="${food.protain}" data-fat="${food.fat}" data-general_weight="${food.general_weight}">\
                                                <p>g</p>\
                                            </div>\
                                        </div>\
                                    </form>\
                                </div>\
                            </div>\
                            <div class="food-submit">\
                                <button type="submit" class="btn search-btn">＋</button>\
                            </div>\
                        </div>\
                    </form>
                    `);
                    
                })
                // // コンテンツ追加
                // // 取得件数を加算してセット
                count += data.foods.length
                console.log(data.foods.length);
                $("#count").val(count);
            })
            //通信失敗した時の処理
            .fail(function () {
            console.log('fail'); 
            });
    }

     // Recipeコンテンツ追加処理
     function ajaxAddContentRecipe() {
        // 追加コンテンツ
        var add_content = "";
        // コンテンツ件数           
        var count =  parseInt($("#count").val());
        //URLのパラメータ取得
        var myrecipe = $('#myrecipe').val(); 
        var keyword = $('#keyword').val(); 
        var clear = $('#clear').val();
        var category_id = $('#category_id').val();
        var date = $('#date').val();
        // ajax処理
        $.ajax({
            headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
            url: '/addrecipe', //通信先アドレスで、このURLをあとでルートで設定します
            method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
            datatype: "json",
            data: { //サーバーに送信するデータ
                'count' : count,
                'myrecipe' : myrecipe,
                'keyword' : keyword,
                'clear' : clear,
                'category_id' : category_id,
                'date' : date,
            },
            })
            //通信成功した時の処理
            .done(function (data) {
                // 管理者画面に食材を追加
                $.each(data.recipes,function(key,recipe){
                    console.log(data);
                    var text1 = '';
                    var text2 = '';
                    var text3 = '';
                    var text4 = '';
                    var text5 = '';
                    text1 =`
                    <div class="food">
                        <div class="food-main">
                            <div class="food-image">
                                <img src="${recipe.image}" alt="" class="">
                            </div>
                            <div class="food-info">
                                <div class="info-container">
                                    <div class="mb-2 hide">
                                        ${recipe.name} 
                                    </div>
                                        <table class="food-table">
                                            <tr class="text-right">
                                                <td height="1rem" width="68">エネルギー：</td>
                                                <td>${recipe.energy}kcal</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td height="1rem" width="68">炭水化物：</td>
                                                <td>${recipe.carbohydrate}g</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="68">タンパク質：</td>
                                                <td>${recipe.protain}g</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="68">脂質：</td>
                                                <td>${recipe.fat}g</td>
                                            </tr>
                                        </table>
                                </div>
                            </div>
                        </div>
                        <div class="food-submit">
                    `
                    if(data.myrecipe_judge[key]){
                        text2 =`
                        <a href="/recipe/create_session/${recipe.id}">編集</a>
                        <a href="/recipe/destory/${recipe.id}">消去</a>
                        `
                    }
                        text3 =`
                            <a href="/recipe/detail/${recipe.id}">詳細</a>
                            <a href="https://twitter.com/share?text=栄養計算サイトからレシピ紹介！！%0aレシピ名：${recipe.energy}%0aエネルギー：${recipe.energy}kcal%0a炭水化物：${recipe.carbohydrate}g%0aタンパク質：${recipe.protain}g%0a脂質：${recipe.fat}g%0aコメント：${recipe.memo}%0a&hashtags=栄養計算サイト"><i class="fab fa-twitter"></i></a>
                            <div class="like-box">
                        `
                    
                    if(!(data.login_user_like[key])){
                        text4 =`
                        <i id = "${recipe.id}" class="${'fas fa-heart like like-' + recipe.id}"></i>
                        <p class="likes-count likes-count-${recipe.id}">${data.like_counts[key]}</p>
                            </div>
                        </div>
                        `
                    }else {
                        text4 =`
                        <i id = "${recipe.id}" class="${'fas fa-heart like pink like-' + recipe.id}"></i>
                        <p class="likes-count likes-count-${recipe.id}">${data.like_counts[key]}</p>
                            </div>
                        </div>
                        `
                    }
                                
                    if(data.myrecipe_judge[key]){
                    text5 = `<div class="ellipse"><p>Myレシピ</p></div>
                            </div>
                            `
                    }
                    $("#recipes").append(text1 + text2 + text3 + text4 + text5);
                    
                })
                
                $.each(data.recipes,function(key,recipe){
                    console.log(data);
                    var text1 = '';
                    var text2 = '';
                    text1 =`
                    <div class="food">
                        <div class="food-main">
                            <div class="food-image">
                                <img src="/${recipe.image}" alt="" class="">
                            </div>
                            <div class="food-info">
                                <div class="info-container">
                                    <div class="mb-2 hide">
                                        ${recipe.name} 
                                    </div>
                                        <table class="food-table">
                                            <tr class="text-right">
                                                <td height="1rem" width="68">エネルギー：</td>
                                                <td>${recipe.energy}kcal</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td height="1rem" width="68">炭水化物：</td>
                                                <td>${recipe.carbohydrate}g</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="68">タンパク質：</td>
                                                <td>${recipe.protain}g</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="68">脂質：</td>
                                                <td>${recipe.fat}g</td>
                                            </tr>
                                        </table>
                                </div>
                            </div>
                        </div>
                        <div class="food-submit">
                            <input type="submit" value='登録' formaction="/record/register/${recipe.id}" class='register-button'>
                            <a href="/recipe/detail/${recipe.id}">詳細</a>
                    `   
                    if(data.myrecipe_judge[key]){
                        text2 = `<div class="ellipse"><p>Myレシピ</p></div>
                            </div>
                        </div>`
                    }

                    $("#register-record").append(text1 + text2);
                })
                // // コンテンツ追加
                // // 取得件数を加算してセット
                count += data.recipes.length;
                console.log(data.recipes.length);
                $("#count").val(count);
            })
            //通信失敗した時の処理
            .fail(function () {
            console.log('fail'); 
            });
    }

});














{/* <script>
window.addEventListener('DOMContentLoaded', function(){
    var id = JSON.parse('<?php echo $id; ?>');
    var carbohydrate = JSON.parse('<?php echo $carbohydrate; ?>');
    var protain = JSON.parse('<?php echo $protain; ?>');
    var fat = JSON.parse('<?php echo $fat; ?>');
    var energy = carbohydrate * 4 + protain * 4 + fat * 9;
    var general_weight = JSON.parse('<?php echo $general_weight; ?>');
    var energy_id = document.getElementById('energy-' + id);
    var carbohydrate_id = document.getElementById('carbohydrate-' + id);
    var protain_id = document.getElementById('protain-' + id);
    var fat_id = document.getElementById('fat-' + id);
    var gram = document.getElementById('amount-text-' + id);
    var num = document.getElementById('num-text-' + id);
    var num_change = document.getElementById('num-change-' + id);
    var amount_change = document.getElementById('amount-change-' + id);
    var num_box = document.getElementById('num-box-' + id);
    var amount_box = document.getElementById('amount-box-' + id);
    gram.addEventListener("input",function(){
        var g = Number(gram.value);    
        if (Number.isInteger(g)){
            var energy_change = Math.round((energy * g / 100)*10)/10;
            var carbohydrate_change = Math.round((carbohydrate * g / 100)*10)/10;
            var protain_change = Math.round((protain * g / 100)*10)/10;
            var fat_change = Math.round((fat * g / 100)*10)/10;
            energy_id.textContent = energy_change + 'g';
            carbohydrate_id.textContent = carbohydrate_change + 'g';
            protain_id.textContent = protain_change + 'g';
            fat_id.textContent = fat_change + 'g';
        }
    });
    num.addEventListener("input",function(){
        var n = Number(num.value);    
        if (Number.isInteger(n)){
            var energy_change = Math.round((energy * general_weight / 100 * n)*10)/10;
            var carbohydrate_change = Math.round((carbohydrate * general_weight / 100 * n)*10)/10;
            var protain_change = Math.round((protain * general_weight / 100 * n)*10)/10;
            var fat_change = Math.round((fat * general_weight / 100 * n)*10)/10;
            energy_id.textContent = energy_change + 'g';
            carbohydrate_id.textContent = carbohydrate_change + 'g';
            protain_id.textContent = protain_change + 'g';
            fat_id.textContent = fat_change + 'g';
        }
    });
    num_change.addEventListener("click",function(){
        amount_box.classList.remove('d-none');
        num_box.classList.add('d-none');
        gram.value = 100;
        num.value = null;
        energy_id.testContent = energy + 'g';
        carbohydrate_id.textContent = carbohydrate + 'g';
        protain_id.textContent = protain + 'g';
        fat_id.textContent = fat + 'g';
    });
    amount_change.addEventListener("click",function(){
        num_box.classList.remove('d-none');
        amount_box.classList.add('d-none');
        var energy_num = Math.round((energy * general_weight / 100)*10)/10;
        var carbohydrate_num = Math.round((carbohydrate * general_weight / 100)*10)/10;
        var protain_num = Math.round((protain * general_weight / 100)*10)/10;
        var fat_num = Math.round((fat * general_weight / 100)*10)/10;
        gram.value = null;
        num.value = 1;
        energy_id.textContent = energy_num + 'g';
        carbohydrate_id.textContent = carbohydrate_num + 'g';
        protain_id.textContent = protain_num + 'g';
        fat_id.textContent = fat_num + 'g';
        
    });
});
</script>  */}