const webpack = require('webpack');
require('dotenv').config({
  path: __dirname +'/.env'
});
const env = process.env;

module.exports = {
  entry: {
    app: './resources/assets/js/app.js',
    vendor: ['jquery', 'socket.io-client']
  },
  output: {
    filename: '[name].js'
  },
  plugins: [
    new webpack.DefinePlugin({
      SOCKETIO_ENDPOINT: JSON.stringify(env.SOCKETIO_ENDPOINT)
    }),
    new webpack.optimize.CommonsChunkPlugin({
      names: ['vendor']
    })
  ],
  module: {
    loaders: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        loader: 'babel',
        query: {
          cacheDirectory: true,
          plugins: ['transform-runtime'],
          presets: ['es2015']
        }
      }
    ]
  }
};
