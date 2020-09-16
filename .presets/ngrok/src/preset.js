const { Preset } = require('use-preset');

module.exports = Preset.make('laravel-boilerplate-ngrok-preset')

  .prompts()
  .input('Your ngrok auth token', 'ngrok_auth_token')
  .chain()

  .edit('docker-compose.yml')
  .title('🐳 Add ngrok job')
  .search(/@use-preset-docker-compose-services$/)
  .addAfter(
    `
  ngrok:
    container_name: laravel-boilerplate-ngrok
    image: wernight/ngrok
    depends_on:
      - app
    networks:
      - app-tier
    ports:
      - 4040:4040
    environment:
      NGROK_AUTH: {NGROK_AUTH_TOKEN}
      NGROK_PORT: host.docker.internal:80
      NGROK_REGION: eu`
  )
  .end()
  .chain()

  .edit('docker-compose.yml')
  .title('🔒 Add ngrok auth token')
  .replace('{NGROK_AUTH_TOKEN}')
  .with(context => context.prompts.ngrok_auth_token)
  .chain();
