const games = document.getElementById('games');

if(games){
    games.addEventListener('click',(e)=>{
        if(e.target.className === 'btn btn-danger delete-game'){
            // alert(2);
            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');
                fetch('/game/delete/'+id,{
                    method:'DELETE'
                }).then(res=>window.location.reload());
            }
        }
    });
}