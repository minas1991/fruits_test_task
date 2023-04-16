<template>
  <main>
    <div class="flex bg-silver-100">
      <div class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto border-r">
        <h2 class="text-3xl font-semibold text-center text-blue-800">Task</h2>
        <div class="flex flex-col justify-between mt-6">
          <aside>
            <ul>
              <li class="border-b border-t border-gray-400">
                <router-link to="/">
                  <span class="mx-4 font-medium">Fruits</span>
                </router-link>
              </li>
              <li class="border-b border-gray-400">
                <router-link to="/favorites">
                  <span class="mx-4 font-medium">Favorites</span>
                </router-link>
              </li>
            </ul>
          </aside>
        </div>
      </div>

      <div class="w-full h-full p-4 m-8 overflow-y-auto">
        <router-view></router-view>
      </div>
    </div>

  </main>
</template>

<script>
export default {
  name: "App",
}
</script>
