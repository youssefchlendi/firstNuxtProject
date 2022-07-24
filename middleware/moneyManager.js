export default function ({ store, error }) {
  if (store.state.auth.user.responsability === null || store.state.auth.user.responsability !== 'money-manager') {
    error({ statusCode: 401, message: 'لست مخول للدخول لهذه الصفحة' })
  }
}
