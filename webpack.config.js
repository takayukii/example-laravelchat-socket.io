var webpack = require('webpack');

module.exports = {
  entry: {
    app: './resources/assets/js/app.js',
    vendor: ['jquery']
  },
  output: {
    filename: '[name].js'
  },
  plugins: [
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
}
