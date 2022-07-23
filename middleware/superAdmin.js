export default function ({ store, error }) {
  // If the user is not authenticated
  let isSuperAdmin = null
  store.state.auth.user.roles?.forEach((role) => {
    if (role.role === 'Super Admin' && role.status === 1) {
      isSuperAdmin = true
    }
  })
  if (!isSuperAdmin) {
    error({ statusCode: 401, message: 'لست مخول للدخول لهذه الصفحة' })
  }
}
