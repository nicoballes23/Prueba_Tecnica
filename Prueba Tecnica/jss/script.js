// Función para obtener la lista de Pokémon desde la PokeAPI
function getPokemonList() {
  fetch('https://pokeapi.co/api/v2/pokemon?limit=1010')
    .then(response => response.json())
    .then(data => {

      // Recorre la lista de Pokémon
      data.results.forEach(pokemon => {
        const pokemonButton = document.createElement('button');
        pokemonButton.textContent = `#${pokemon.url.split('/')[6]} - ${pokemon.name.toUpperCase()}`; 
        pokemonButton.addEventListener('click', () => redirectToPokemonPage(pokemon.name));
        pokemonList.appendChild(pokemonButton);
      });
    })
    .catch(error => {
      console.log(error);
    });
}

//función obtener lista de Pokémon
getPokemonList();


// Obtiener la referencia al elemento con el ID "pokemonList"
const pokemonList = document.getElementById('pokemonList');

//obtener la información de un Pokémon específico
function getPokemonData(pokemonName) {
  fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`)
    .then(response => response.json())
    .then(data => {
      const pokemonData = document.getElementById('pokemonData');

      // Crea elementos para mostrar la información-estadísticas Pokémon
      const name = document.createElement('h2'); 
      name.textContent = data.name; 
      pokemonData.appendChild(name); 


      //Sprites y/o img
      const sprite = document.createElement('img');
      sprite.src = data.sprites.front_default;
      pokemonData.appendChild(sprite);

      //Tipos-pokemon
      const typesTitle = document.createElement('h4');
      typesTitle.textContent = 'Types:';
      pokemonData.appendChild(typesTitle);

      data.types.forEach(type => {
        const typeSpan = document.createElement('span');
        typeSpan.textContent = type.type.name;
        typeSpan.classList.add('pokemon-type');
        pokemonData.appendChild(typeSpan);
      });

      //Stats y/o Estadísticas
      const statsTitle = document.createElement('h3');
      statsTitle.textContent = 'Stats:';
      pokemonData.appendChild(statsTitle);

      //Stats del pokemon
      const statsList = document.createElement('ul');
      data.stats.forEach(stat => {
        const statItem = document.createElement('li');
        statItem.textContent = `${stat.stat.name}: ${stat.base_stat}`;
        statsList.appendChild(statItem);
      });
      pokemonData.appendChild(statsList);
    })

    // Captura errores que ocurra durante la solicitud de la API
    .catch(error => {
      console.log(error);
    });
}

// Obtiene el nombre del Pokémon de la URL y llama a la función para obtener su información
const urlParams = new URLSearchParams(window.location.search);
const pokemonName = urlParams.get('name');
getPokemonData(pokemonName);


// Función para redirigir a la página de información del Pokémon
function redirectToPokemonPage(pokemonName) {
  window.location.href = `pokemon.html?name=${pokemonName}`;
}


