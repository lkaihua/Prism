<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properities -->
  <title>Prism - search similar images based on color spectrum</title>

  <link rel="stylesheet" type="text/css" href="semantic.min.css">
  <link rel="stylesheet" type="text/css" href="index.css">

  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>

  <!-- Used with Tab History !-->
  <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>-->
  <script src="semantic.min.js"></script>
  <script src="Chart.min.js"></script>

</head>
<body id="sink">

<div class="demo container">
    <div class="ui header">
      <i class=" icon"><img src="images/logo.png" width="60"></i>
      <div class="content">
        Prism
        <div class="sub header">search similar images based on color spectrum</div>
      </div>
    </div>

    <div class="ui ordered steps">
      <a class="active step" link-tab="#card-sig" id="step-pic">
        <div class="content">
          <div class="title">Picture</div>
          <div class="description">Choose a picture</div>
        </div>
      </a>
      <a class="disabled step" link-tab="#card-sig" id="step-sig">
        <div class="content">
          <div class="title">Signature</div>
          <div class="description">Plot a signature</div>
        </div>
      </a>
      <a class="disabled step" link-tab="#card-sketch" id="step-sketch">
        <div class="content">
          <div class="title">Sketch</div>
          <div class="description">Calculate a sketch</div>
        </div>
      </a>
      <a class="disabled step" link-tab="#card-results" id="step-results">
        <div class="content">
          <div class="title">Results</div>
          <div class="description">Find most similar pictures</div>
        </div>
      </a>
    </div>
  
    <div class="ui card" id="card-init">
        <div class="header"></div>
        <div class="ui green button large " id="next-1-2">Start with a new picture</div>
        <img src="images/wireframe/white-image.png" width="350px" />
    </div>

    <div class="ui card" id="card-pic">
      <div class="image">
        <img src="images/wireframe/white-image.png" id="chosen-pic">
      </div>
      <div class="content">
        <div class="header">Choose a picture</div>
        <div class="description">Start with picking up a random picture from the dataset.</div>
      </div>
      <div class="extra content center aligned">
        
      </div>
    </div>

    <div class="ui card tab" id="card-sig">
      <div class="plot_container">
        <canvas id="sig-plot"></canvas>
      </div>
      <div class="content">
        <div class="header">Plot a signature</div>
        <div class="description">
          <p>To find similar images, one basic idea is to start with the similar colour histograms they share, and thus the number of pixels in similar colours should be close. 
          <div class="image">
            <img src="images/bird.jpg"/>
          </div>
          <p>Here we hash all pixels into 64 bins, according to corresponding area of their colors. These <b>64 integers</b> form a <b>signature</b>, which is able to describe the colour information of original picture. </div>
      </div>
      <div class="extra content">
        <div class="ui blue button large  right floated" id="next-2-3">Next step</div>
      </div>
    </div>

    <div class="ui card tab" id="card-sketch">
      <div class="plot_container">
        <canvas id="sketch-plot"></canvas>
      </div>
      <div class="content">
        <div class="header">Calculate a sketch</div>
        <div class="description">With the 64-int signature <b>x</b>, we pick 128 random vectors and apply them to signature by computing <b>v1.x,v2.x,...,v128.x</b> and then replace any positive value by <b>1</b> and any negative value by <b>0</b>, to get a 128-bit (16-byte) sketch. The sketch contains information to find similar pictures, but only consumes <b>1/1500</b> storage of the original file.</div>
      </div>
      <div class="extra content">
        <div class="ui blue button large  right floated" id="next-3-4">Next step</div>
      </div>
    </div>

    <div class="ui card tab" id="card-results">
      <div class="content">
        <div class="ui four cards">
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
        </div>
        <div class="ui four cards">
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
        </div>
        <div class="ui four cards">
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
          <div class="card">
            <div class="image">
              <a class="ui corner red label"><i class="heart icon"></i></a>
              <img src="images/wireframe/white-image.png">
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="header">Find most similar pictures</div>
        <div class="description">By computing dot of this sketch and sketch-matrix of the whole dataset, we will get an array, which contains similarities between the original image and the others. After sorting this array descending, the top 12 are listed above. In average, one search process is usually done within <b>20ms</b>, from generating a signature to find all similar candidates.</div>
      </div>
      <div class="extra content">
        <div class="ui blue button large  right floated" id="next-4-1">Start a new search</div>
      </div>
    </div>


    <div class="comments">
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES * * */
            var disqus_shortname = 'prismproject';
            
            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
    </div>

</div>


<div class="ui inverted footer vertical segment">
  <div class="ui stackable center aligned page grid">
    <div class="ten wide column">
      <div class="ui three column center aligned stackable grid">
        <div class="column">
          <h5 class="ui inverted header">Resources</h5>
          <div class="ui inverted link list">
            <a class="item" href="http://aloi.science.uva.nl/">The Amsterdam library of object images</a>
            <a class="item" href="http://en.wikipedia.org/wiki/Color_histogram#Example">Color histogram</a>
          </div>
        </div>
        <div class="column">
          <h5 class="ui inverted header">Library</h5>
          <div class="ui inverted link list">
            <a class="item">Semantic UI</a>
            <a class="item">ChartJS</a>
            <a class="item">jQuery</a>
          </div>
        </div>
        <div class="column">
          <h5 class="ui inverted header">About me</h5>
          <div class="ui inverted link list">
            <a class="item">Kain Liu</a>
            <a class="item">March 2015</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$(document)
  .ready(function(){

    $(".steps a").click(function(event) {
        event.preventDefault();
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
        var tab = $(this).attr("link-tab");
        $(".tab").not(tab).css("display", "none");
        $(tab).fadeIn();
    });


    $("#next-1-2").click(function(){

        // remove the start button
        $("#next-1-2").addClass("disabled").appendTo("#card-pic > .extra");
        $("#next-2-3").addClass("disabled");
        $("#card-init").hide();
        $("#card-pic").show();

        $(".steps .disabled").removeClass("disabled");
        $("#step-sig").click();

        var newPicId = location.href.split("?")[1] || Math.ceil(Math.random() * 1000);
        // choose the most bright one, better result
        var newPic = '/public/dataset/' +  newPicId + '/' +  newPicId + '_l3c3.png';
        $("#chosen-pic").attr("src", newPic).data("pic-id", (newPicId - 1) * 24 + 3 * 3 + 3);

        $.ajax({
            type: 'GET',
            url: 'fetch.php?pic=' + $("#chosen-pic").data("pic-id"),
            success: function( response ) {
                var d = $.parseJSON(response)[0];
                $("#next-1-2").data(
                    "pic-info", d
                )
                drawPlot("sig-plot", "Line", d.sig, 8)

                // fetch picture results
                var d = $("#next-1-2").data("pic-info").candi.split(" ");
                $("#card-results .card img").each(function(index, img){
                    img.src = "/public/" + d[index];
                })
            },
            complete: function(){
                $("#next-1-2").removeClass("disabled").text("Re-pick");
                $("#next-2-3").removeClass("disabled");
            }
        })
    })


    $("#next-2-3").click(function(){
        // show next tab
        $("#step-sketch").click();
        var d = [];
        for(var i = 0; i < 128; i ++){
            if(Math.random() < 0.5){
                d.push(1)
            }else{
                d.push(0)
            }
        }
        drawPlot("sketch-plot", "Radar", d, 16)

    })

    $("#next-3-4").click(function(){
        $("#step-results").click();

        // hide hearts after 4th choice
        $("#card-results .card .corner").each(function(index, corner){
            if(index >= 4){
                corner.style.display = 'none';
            }
        })
    })

    $("#next-4-1").click(function(){
        $("#step-pic").click();
        $("#next-1-2").click();
    })

})    


function drawPlot(plot, type, vals, interval){
    // could be Line, Bar, Rador...
    type = type || "Line";
    variable = type + '-' + plot;
    interval = interval || 10;
    y_value = typeof vals == "string" ? vals.split(" ") : vals;
    //y_value = "0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 113 0 0 0 428 26 0 0 0 0 0 0 0 0 0 0 0 0 0 0 455 108 0 0 134 1432 31 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2060 48 0 0 232 124 0".split(" ");

    // hack: show less labels
    var x_labels = [];
    for(var i = 1; i < y_value.length + 1; i++){
        if(i % interval == 0){
            x_labels.push(i)
        }else{
            x_labels.push(" ")
        }
    }

    var chartData = {
        labels : x_labels,
        datasets : [
            {
                // label: "Signature Plot",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : y_value
            }
        ]
    };

    var ctx = document.getElementById(plot).getContext("2d");

    // wait a moment before painting, in case the vendor div is fading in
    // never plot before
    if(!window[variable]){
      setTimeout(function(){
          window[variable] = new Chart(ctx)[type](chartData, {
              responsive: true,
              showTooltips: false
          });
      }, 300);
    }else{
      for(var i = 0; i < y_value.length; i ++){
        window[variable].datasets[0].points[i].value = y_value[i];
      }
      window[variable].update();
    }
    
    
}
</script>

</body>

</html>
