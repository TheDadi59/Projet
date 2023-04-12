<!-- Logout Modal-->

<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajoutez un aliment</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="search" placeholder="Search...">
                <ul id="suggestions"></ul>
                <script>
                    $.ajax({
                        url: chemin + "/backend/aliment.php",
                        type: 'GET',
                        dataType: 'json',
                        success: function(array) {
                            const searchInput = document.getElementById('search');
                            const suggestionsList = document.getElementById('suggestions');

                            searchInput.addEventListener('input', () => {
                                const inputValue = searchInput.value.toLowerCase();
                                const suggestions = array['data'].filter(item => item['nom_alim'].toLowerCase().includes(inputValue));

                                suggestionsList.innerHTML = '';

                                if (inputValue.length > 0) {
                                    suggestions.forEach(item => {
                                        const li = document.createElement('li');
                                        li.innerText = item['nom_alim'];
                                        suggestionsList.appendChild(li);
                                    });
                                }
                            });

                            suggestionsList.addEventListener('click', event => {
                                if (event.target.tagName === 'LI') {
                                    searchInput.value = event.target.innerText;
                                    suggestionsList.innerHTML = '';
                                }
                            });
                        }
                    });

                    function functionSearch() {
                        alert($('#search').value);
                    }
                </script>

                <input type="text" id="addQuantite" placeholder="Quantite...">
                <input type="date" id="addDateConsommation" placeholder="Date de consommation">
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id = "addAliment" href="index.php">Valider</a>
                <script>
                    $("#addAliment").on("click",addAlimentF)
                    function addAlimentF(){
                        
                        var searchAliment = $("#search").val();
                        var searchQuantite = $("#addQuantite").val();
                        var searchDateConsommation = $("#addDateConsommation").val();
                        var idAliment;
                        $.ajax({
                                url: chemin + "/backend/aliment.php?nom_alimentation="+searchAliment,
                                type: 'GET',
                                async: false,
                                dataType: 'json',
                                
                            })
                            .done(function (response) {
                                idAliment = (JSON.parse(JSON.stringify(response.data)))[0].id;
                                console.log(idAliment);
                            });
                        $.ajax({
                        url: chemin + "/backend/consomme.php",
                        type: 'POST',
                        dataType: 'json',
                        data:{
                            "id_alim" : idAliment,
                            "id_user" : id,
                            "quantité" : searchQuantite,
                            "date_consommation" : searchDateConsommation,
                        },
                        success: function(array) {

                        }
                    });
                    }
                </script>
            </div>
        </div>
    </div>
</div>