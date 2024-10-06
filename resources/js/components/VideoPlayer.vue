<template>
    <div>
        <h1>Video Player</h1>
        <video ref="videoPlayer" controls style="width: 100%">
            <source :src="videoUrl" type="video/mp4" />
        </video>

        <div style="margin-top: 10px">
            <button @click="setVideo1">Play Video 1</button>
            <button @click="setVideo2">Play Video 2</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            videoUrl: "/storage/videos/video1.mp4",
        };
    },
    methods: {
        setVideo1() {
            this.videoUrl = "/storage/videos/video1.mp4";
            this.reloadVideo();
        },
        setVideo2() {
            this.videoUrl = "/storage/videos/video2.mp4";
            this.reloadVideo();
        },
        reloadVideo() {
            const video = this.$refs.videoPlayer;
            video.load();
        },
    },
};
</script>

<style scoped>
button {
    margin-right: 10px;
    padding: 5px 15px;
}
</style>
