const { registerBlockType } = wp.blocks;
const { SelectControl, Spinner } = wp.components;
const { useState, useEffect } = wp.element;

registerBlockType('pokepress/block', {
    title: 'PokePress',
    icon: 'smiley',
    category: 'widgets',
    attributes: {
        pokemonId: { type: 'string', default: '' },
        pokemonData: { type: 'object', default: {} },
    },

    edit({ attributes, setAttributes }) {
        const [loading, setLoading] = useState(false);
        const [error, setError] = useState(null);
        const [pokemonOptions, setPokemonOptions] = useState([]);

        useEffect(() => {
            fetch('https://pokeapi.co/api/v2/pokemon?limit=100')
                .then((res) => {
                    if (!res.ok) {
                        throw new Error('Failed to fetch Pokémon list');
                    }
                    return res.json();
                })
                .then((data) => {
                    setPokemonOptions(
                        data.results.map((item) => ({
                            label: item.name,
                            value: item.name,
                        }))
                    );
                })
                .catch((err) => setError(err.message));
        }, []);

        const fetchPokemonData = (pokemonId) => {
            setLoading(true);
            setError(null);

            fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonId}`)
                .then((res) => {
                    if (!res.ok) {
                        throw new Error('Failed to fetch Pokémon data');
                    }
                    return res.json();
                })
                .then((data) => {
                    setAttributes({ pokemonId, pokemonData: data });
                    setLoading(false);
                })
                .catch((err) => {
                    setError(err.message);
                    setLoading(false);
                });
        };

        return (
            <div>
                <SelectControl
                    label="Select Pokémon"
                    value={attributes.pokemonId}
                    options={pokemonOptions}
                    onChange={fetchPokemonData}
                />

                {loading && <Spinner />}

                {error && (
                    <Notice status="error" isDismissible={false}>
                        {error}
                    </Notice>
                )}

                {attributes.pokemonData && !loading && !error && (
                    <div>
                        <h3>{attributes.pokemonData.name}</h3>
                        <img
                            src={attributes.pokemonData.sprites.front_default}
                            alt={attributes.pokemonData.name}
                        />
                        <ul>
                            <li>Height: {attributes.pokemonData.height}</li>
                            <li>Weight: {attributes.pokemonData.weight}</li>
                            <li>
                                Types:{' '}
                                {attributes.pokemonData.types
                                    .map((type) => type.type.name)
                                    .join(', ')}
                            </li>
                        </ul>
                    </div>
                )}
            </div>
        );
    },

    save() {
        return null;
    },
});
