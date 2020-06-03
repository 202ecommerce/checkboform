const path = require('path');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');

const minimizers = [];
const plugins = [
    new FixStyleOnlyEntriesPlugin(),
    new MiniCssExtractPlugin({
        filename: '[name].css',
    }),
];

const config = {
    entry: {
        'js/settings/settings_form': './_dev/js/settings/settings_form.js',

    },

    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './views/'),
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                        },
                    },
                ],
            },

            {
                test: /\.(s)?css$/,
                use: [
                    {loader: MiniCssExtractPlugin.loader},
                    {loader: 'css-loader'},
                    {loader: 'postcss-loader'},
                    {loader: 'sass-loader'},
                ],
            },

        ],
    },

    externals: {
        $: '$',
        jquery: 'jQuery',
    },

    plugins,

    optimization: {
        minimizer: minimizers,
    },
    devtool: this.mode === 'development' ? 'eval' : 'cheap-source-map',
    resolve: {
        extensions: ['.js', '.scss', '.css'],
        alias: {
            '~': path.resolve(__dirname, './node_modules'),
            '$img_dir': path.resolve(__dirname, './views/img')
        },
    },
};

module.exports = (env, argv) => {
    // Production specific settings
    if (argv.mode === 'production') {
        const terserPlugin = new TerserPlugin({
            cache: true,
            sourceMap: true,
            extractComments: /^\**!|@preserve|@license|@cc_on/i, // Remove comments except those containing @preserve|@license|@cc_on
            parallel: true,
            terserOptions: {
                drop_console: true,
            },
        });

        config.optimization.minimizer.push(terserPlugin);
    }

    return config;
};
