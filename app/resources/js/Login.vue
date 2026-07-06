<template>
  <div class="min-h-screen bg-white text-white flex items-center justify-center px-6">
    <div class="grid lg:grid-cols-2 w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden">

      <!-- Left Side -->
      <div class="hidden lg:flex flex-col justify-center bg-gradient-to-br from-slate-900 via-white-600 to-indigo-700 text-white p-16">
        <h1 class="text-5xl font-bold leading-tight">
          Welcome Back
        </h1>

        <p class="mt-6 text-cyan-100 text-lg leading-relaxed">
          Access your <span class="text-white-900 text-md font-bold">Laura-Belle</span> dashboard and continue managing your business with ease.
        </p>

        <div class="mt-12 space-y-5">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-cyan-300"></div>
            <span>Secure Authentication</span>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-cyan-300"></div>
            <span>Fast Performance</span>
          </div>

          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-cyan-300"></div>
            <span>Real-time Inventory</span>
          </div>
        </div>
      </div>

      <!-- Right Side -->
      <div class="flex items-center justify-center p-8 lg:p-16">

        <div class="w-full max-w-md">

          <div class="mb-10">
            <h2 class="text-4xl font-bold text-slate-800">
              Sign In
            </h2>

            <p class="text-slate-500 mt-2">
              Welcome back! Please enter your details.
            </p>
          </div>

          <form
            @submit.prevent="submitLogin"
            class="space-y-6"
          >

            <!-- Email -->
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">
                Email
              </label>

              <input
                v-model="email"
                type="email"
                name="email"
                placeholder="Enter your email"
                class="w-full text-slate-900 rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition duration-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100"
              />

              <div
                v-if="emailError"
                class="text-red-500 text-sm mt-2"
              >
                {{ emailError }}
              </div>
            </div>

            <!-- Password -->
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">
                Password
              </label>

              <input
                v-model="password"
                type="password"
                name="password"
                placeholder="Enter your password"
                class="w-full text-slate-900 rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition duration-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100"
              />

              <div
                v-if="passwordError"
                class="text-red-500 text-sm mt-2"
              >
                {{ passwordError }}
              </div>
            </div>

            <div
              v-if="formError"
              class="text-red-500 text-sm"
            >
              {{ formError }}
            </div>

            <div class="flex justify-between text-sm">
              <RouterLink
                to="/reset-password"
                class="text-cyan-600 hover:text-cyan-700 font-medium cursor-pointer"
              >
                Forgot Password?
              </RouterLink>

              <RouterLink
                to="/register"
                class="text-cyan-600 hover:text-cyan-700 font-medium cursor-pointer"
              >
                Register
              </RouterLink>
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="w-full rounded-xl bg-gradient-to-br from-slate-900 via-white-600 to-indigo-700 text-white py-3.5 font-semibold text-white transition hover:bg-cyan-700 active:scale-[0.98] disabled:opacity-60 cursor-pointer"
            >
              {{ loading ? "Signing in..." : "Sign In" }}
            </button>

          </form>

        </div>

      </div>

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

      if (!this.email.includes("@gmail.com")) {
        this.emailError = "Email must be a Gmail address.";
        return;
      }

      // console.log("Email: ", this.email);
      // console.log("Password: ", this.password);

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