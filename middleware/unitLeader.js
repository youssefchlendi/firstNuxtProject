export default function ({ store, error }) {
  let isUnitLeader = null
  store.state.auth.user.roles?.forEach((role) => {
    if (role.role === 'Unit Leader' && role.status === 1) {
      isUnitLeader = true
    }
  })
  if (!isUnitLeader) {
    error({ statusCode: 401, message: 'لست مخول للدخول لهذه الصفحة' })
  }
}
