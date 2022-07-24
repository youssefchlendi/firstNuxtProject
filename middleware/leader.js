export default function ({ store, error }) {
  // If the user is not authenticated
  let isLeader = null
  store.state.auth.user.roles.forEach((role) => {
    if (role.role.includes('Leader') && role.status === 1) {
      isLeader = true
    }
  })
  if (!isLeader) {
    error({ statusCode: 401, message: 'لست مخول للدخول لهذه الصفحة' })
  }
}
