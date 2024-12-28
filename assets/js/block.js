const { registerBlockType } = wp.blocks;
const { SelectControl, Spinner } = wp.components;
const { useState, useEffect } = wp.element;

registerBlockType( 'pokepress/block', {
    title: 'Pokémon Info',
    icon: 'smiley',
    category: 'widgets',
    attributes: {
        pokemonId: { type: 'string', default: '' },
        pokemonData: { type: 'object', default: {} }
    },

    edit( { attributes, setAttributes } ) {
        const [ loading, setLoading ] = useState( false );
        const [ pokemonOptions, setPokemonOptions ] = useState( [] );

        useEffect( () => {
            // Fetch list of Pokemon for selection
            fetch( 'https://pokeapi.co/api/v2/pokemon?limit=100' )
                .then( res => res.json() )
                .then( data => {
                    setPokemonOptions( data.results.map( ( item ) => ({
                        label: item.name,
                        value: item.name
                    })));
                });
        }, []);

        const fetchPokemonData = ( pokemonId ) => {
            setLoading( true );
            fetch( `https://pokeapi.co/api/v2/pokemon/${pokemonId}` )
                .then( res => res.json() )
                .then( data => {
                    setAttributes( { pokemonId, pokemonData: data } );
                    setLoading( false );
                });
        };

        return (
            <div>
                <SelectControl
                    label="Select Pokémon"
                    value={ attributes.pokemonId }
                    options={ pokemonOptions }
                    onChange={ fetchPokemonData }
                />

                { loading && <Spinner /> }

                { attributes.pokemonData && !loading && (
                    <div>
                        <h3>{ attributes.pokemonData.name }</h3>
                        <img src={ attributes.pokemonData.sprites.front_default } alt={ attributes.pokemonData.name } />
                        <ul>
                            <li>Height: { attributes.pokemonData.height }</li>
                            <li>Weight: { attributes.pokemonData.weight }</li>
                            <li>Types: { attributes.pokemonData.types.map( ( type ) => type.type.name ).join(', ') }</li>
                        </ul>
                    </div>
                )}
            </div>
        );
    },

    save() {
        return null; // Will be rendered dynamically by PHP
    }
});
