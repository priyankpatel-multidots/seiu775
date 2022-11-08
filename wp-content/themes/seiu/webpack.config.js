const path = require('path')

module.exports = {
  mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
  entry: [
    './js/app.js',
    './sass/style.scss'
  ],
  output: {
    filename: 'app.js',
    path: path.resolve(__dirname, 'build'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        use: [
          {
            loader: 'babel-loader'
          }
        ]
      },
      {
        test: /\.s[ac]ss$/i,
        loaders: [
          {
            loader: 'file-loader',
            options: {
              name: 'css/[name].css',
            }
          },
          {
            loader: 'extract-loader'
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap: process.env.NODE_ENV === 'development'
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: process.env.NODE_ENV === 'development'
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: process.env.NODE_ENV === 'development'
            }
          },
        ]
      },
      {
        test: /\.svg$/,
        loader:
          'svg-sprite?' +
          JSON.stringify({
            name: '[name]'
          })
      }
    ]
  }
}
