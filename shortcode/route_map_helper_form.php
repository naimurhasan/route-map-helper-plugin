<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'../api/from.php' );

function route_map_helper_form_shortcode() {
    ob_start();
    ?> 
    <!-- your contents/html/(maybe in separate file to include) code etc -->
    <form name="route_map_search_form">
        <div class="mf-input-wrapper">
            <label class="mf-input-label">From </label>
            <input type="text" id="route_map_input_from" class="mf-input" required placeholder="e.g. DA1 or Heathrow Airport">
            <div class="input-results" id="from_input_results" style="display:none;">
                <ul>
                    <?php 
                        foreach (get_form_array() as $location_name) {
                            echo "<li>$location_name</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
       <div class="mf-input-wrapper">
            <label class="mf-input-label">To </label>
            <input type="text" id="route_map_input_to" class="mf-input" disabled required placeholder="Please select starting first.">
        </div>
    </form>
    <script>

        function clog(object){
            console.log(object)
        }

        var from_input = document.getElementById("route_map_input_from")
        var from_input_result = document.getElementById("from_input_results")
        var from_list_ul = document.querySelector('#from_input_results > ul')
        var li = from_list_ul.getElementsByTagName("li");

        // on from serach text change
        from_input.addEventListener("keyup", function(evt) {

            const searchText = evt.target.value.toUpperCase() 

            // display list if user has written anything on input
            
            if(searchText.trim() == ""){
                from_input_result.style.display = "none"
            }else{
                from_input_result.style.display = ""
            }

            var displayResultCount = 0
            for (i = 0; i < li.length; i++) {
                
                // hide everything after showing 5 results
                if(displayResultCount>4){
                    li[i].style.display = "none";
                    continue;
                }

                txtValue = li[i].textContent || li[i].innerText;
                if (txtValue.toUpperCase().indexOf(searchText) > -1) {
                    li[i].style.display = "";
                    displayResultCount++;
                } else {
                    li[i].style.display = "none";
                }
            }

        });

        from_input.addEventListener("change", function(evt){
            console.log(evt.target.value)
        })

        
        for(var i = 0; i<li.length; i++){
            li[i].addEventListener("click", function(evt){
                var thisOptionText = evt.target.content || evt.target.innerText
                from_input.value = thisOptionText
                // console.log(thisOptionText)
                from_input_result.style.display = "none"

                // make border green
                from_input.style.border = "1px solid green"
            })
        }

    </script>
    <?php
  
    return ob_get_clean();
    
}
add_shortcode( 'route_map_helper_form', 'AAALRouteMapHelper\route_map_helper_form_shortcode' );

