export default function ({ store, redirect }) {
  // If the user is not authenticated
  let isSuperAdmin = null
  store.state.auth.user.roles?.forEach((role) => {
    if (role.role === 'Super Admin' && role.status === 1) {
      isSuperAdmin = true
    }
  })
  if (!isSuperAdmin) {
    return redirect({ name: 'index' })
  }
}
