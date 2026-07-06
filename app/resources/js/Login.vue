<template>
  <div class="min-h-screen bg-white text-white flex items-center justify-center">
    <div class="text-center space-y-4 w-full max-w-md px-4">
      <h1 class="text-4xl font-semibold bg-gradient-to-br from-cyan-500 to-blue-500 bg-clip-text text-transparent">
        Welcome to Laura-Belle
      </h1>

      <form @submit.prevent="submitLogin" class="space-y-2 flex flex-col items-center mt-10 w-full">
        <div class="w-full p-[1px] rounded-md bg-gradient-to-br from-cyan-500 to-blue-500 focus-within:from-blue-500 focus-within:to-cyan-700">
          <input
            v-model="email"
            type="email"
            name="email"
            placeholder="Email@gmail.com"
            class="w-full px-2 py-2 rounded-md text-black bg-white outline-none"
          />
        </div>

        <div class="w-full p-[1px] rounded-md bg-gradient-to-br from-cyan-500 to-blue-500 focus-within:from-blue-500 focus-within:to-cyan-700 mt-2">
          <input
            v-model="password"
            type="password"
            name="password"
            placeholder="*********"
            class="w-full px-2 py-2 rounded-md text-black bg-white outline-none"
          />
        </div>

        <div v-if="emailError" class="text-red-500 text-sm mt-1">{{ emailError }}</div>
        <div v-if="passwordError" class="text-red-500 text-sm mt-1">{{ passwordError }}</div>
        <div v-if="formError" class="text-red-500 text-sm mt-1">{{ formError }}</div>

        <div class="flex justify-between w-full mt-2 text-sm text-gray-500">
          <RouterLink to="/reset-password" class="cursor-pointer hover:underline">Forgot Password?</RouterLink>
          <RouterLink to="/register" class="cursor-pointer hover:underline">Register</RouterLink>
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="relative group border-none bg-transparent p-0 outline-none cursor-pointer font-mono font-light uppercase text-base mt-3"
        >
          <span class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-25 rounded-lg transform translate-y-0.5 transition duration-[600ms] ease-[cubic-bezier(0.3,0.7,0.4,1)] group-hover:translate-y-1 group-hover:duration-[250ms] group-active:translate-y-px"></span>
          <span class="absolute top-0 left-0 w-full h-full rounded-lg bg-gradient-to-l from-[hsl(217,33%,16%)] via-[hsl(217,33%,32%)] to-[hsl(217,33%,16%)]"></span>
          <div class="relative flex items-center justify-between py-3 px-6 text-lg text-white rounded-lg transform -translate-y-1 bg-gradient-to-r from-[#f27121] via-[#e94057] to-[#8a2387] gap-3 transition duration-[600ms] ease-[cubic-bezier(0.3,0.7,0.4,1)] group-hover:-translate-y-1.5 group-hover:duration-[250ms] group-active:-translate-y-0.5 brightness-100 group-hover:brightness-110">
            <span class="select-none">{{ loading ? 'Signing in...' : 'Submit' }}</span>
            <svg viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-2 -mr-1 transition duration-250 group-hover:translate-x-1">
              <path clip-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" fill-rule="evenodd"></path>
            </svg>
          </div>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      emailError: "",
      passwordError: "",
      formError: "",
      loading: false
    };
  },
  methods: {
    async submitLogin() {
      this.emailError = "";
      this.passwordError = "";
      this.formError = "";

      // if (!this.email.includes("@example.com")) {
      //   this.emailError = "Email must be a Gmail address.";
      //   return;
      // }

      const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
      if (!passwordRegex.test(this.password)) {
        this.passwordError = "Password must be at least 8 characters, include 1 uppercase letter and 1 number.";
        return;
      }

      this.loading = true;
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "";

      try {
        const response = await fetch("/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Accept": "application/json",
            "X-CSRF-TOKEN": token
          },
          body: new URLSearchParams({
            email: this.email,
            password: this.password
          })
        });

        if (response.redirected || response.ok) {
          window.location.assign(response.url);
          return;
        }

        const data = await response.json().catch(() => ({}));
        this.formError = data.message || "Invalid credentials";
      } catch (error) {
        this.formError = "Unable to reach the server right now.";
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>