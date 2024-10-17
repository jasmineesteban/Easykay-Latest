var sidepanel = L.Control.extend({
    options: {
        position: 'topleft'
    },
    onAdd: function (map) {
        var container = L.DomUtil.create('div', "sidepanel-content");
        container.innerHTML =  `

        <button class="btn btn-primary open-side px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidepanelScrolling"
         aria-controls="sidepanelScrolling"><i class="fa-solid fa-caret-right fs-6"></i></button>
        
         <div class="offcanvas offcanvas-start shadow-sm" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="sidepanelScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header sidepanel-header py-2">
                <div class="row">
                    <div class="col-2 m-auto"><img class="sidepanel-logo w-100" src="../../images/logo.png" alt="Easykay Logo"></div>
                    <div class="col-7"><a class="navbar-brand fs-5" href="../../index.php">EasyKay</a></div>
                    <div class="col-3 text-end">
                    <button type="button" class="fa-solid fa-xmark btn fs-5 mx-2 my-1 col-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    
                    </div>
                </div>
            </div>
            <div class="offcanvas-body sidepanel-body">
                <div class="location-form">
                    <form class="" method="POST" id="myGoForm">
                        <input class="form-control mb-2" type="text" placeholder="Origin" id="origin">
                        <input class="form-control mb-3" type="text" placeholder="Your Destination" id="destination">
                    
                        <div class="d-flex mb-3 ">
                            <div class="col-9 col-lg d-flex justify-content-center align-items-center">
                                <span class="fa-solid fa-user"> <span class="mx-2 me-3 "> Passenger</span></span>
                                <div class="input-group-append">
                                    <button class="button px-2" type="button" onclick="decrementValue()"> - </button>
                                </div>
                                <div class="input-group-num">
                                    <input type="number" class="" id="passengerInput" value="1" min="1" max="3" readonly>
                                </div>
                                <div class="input-group-prepend">
                                    <button class="button px-2" type="button" onclick="incrementValue()">+</button>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button type="submit" class="btn btn-outline-primary go">Go</button>
                            </div>
                        </div>  
                    </form>
                </div>
                <hr>
                <div class="travels p-2 bg-light">

                </div>
                <hr>
                <div class="sidepanel-footer">
                <div><p class="text-muted text-end pt-2">*Price may vary according to the time of your commute.</p></div>
            </div>
            </div>
            
        </div>

        `;
       
    return container;
}
})

var sidepanelInstance = new sidepanel();
sidepanelInstance.addTo(map);

function incrementValue() {
    var value = parseInt(document.getElementById('passengerInput').value, 10);
    value = isNaN(value) ? 1 : value;
    value = value < 3 ? value + 1 : 3;
    document.getElementById('passengerInput').value = value;
}

function decrementValue() {
    var value = parseInt(document.getElementById('passengerInput').value, 10);
    value = isNaN(value) ? 1 : value;
    value = value > 1 ? value - 1 : 1;
    document.getElementById('passengerInput').value = value;
}
