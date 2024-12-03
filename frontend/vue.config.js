module.exports = {
  //Rules copied and modified from base.js in vue-cli
  chainWebpack: (config) => {
    const svgRule = config.module.rule('svg');
    const imagesRule = config.module.rule('images');

    imagesRule
      .test(/\.(png|jpe?g|gif|webp)(\?.*)?$/)
      .use('url-loader')
      .loader(require.resolve('url-loader'))
      .options({
        limit: 4096,
        // use explicit fallback to avoid regression in url-loader>=1.1.0
        fallback: {
          loader: require.resolve('file-loader'),
          options: {
            name: '[name].[hash:8].[ext]',
          },
        },
      });

    svgRule
      .test(/\.(svg)(\?.*)?$/)
      .use('file-loader')
      .loader(require.resolve('file-loader'))
      .options({
        name: '[name].[hash:8].[ext]',
      });
  },
  transpileDependencies: [
    'vue-meta',
  ],
  pluginOptions: { webpackBundleAnalyzer: { openAnalyzer: false } },
};
