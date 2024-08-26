package com.wxrk.ui.fragment


import android.net.Uri
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.navigation.fragment.findNavController
import com.bumptech.glide.Glide
import com.google.android.exoplayer2.*
import com.google.android.exoplayer2.source.MediaSource
import com.google.android.exoplayer2.source.ProgressiveMediaSource
import com.google.android.exoplayer2.ui.AspectRatioFrameLayout
import com.google.android.exoplayer2.upstream.DataSource
import com.google.android.exoplayer2.upstream.DefaultDataSourceFactory
import com.google.android.exoplayer2.util.Util
import com.wxrk.BaseFragment
import com.wxrk.R
import com.wxrk.databinding.FragmentSponserAdsBinding
import com.wxrk.model.dashbord.Banners


class Video_Sponser_Fragment : BaseFragment(R.layout.fragment_sponser_ads) {

    lateinit var binding: FragmentSponserAdsBinding
    lateinit var item: Banners
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentSponserAdsBinding.inflate(inflater, container, false)
        playvideo()

        return binding.root
    }
    fun playvideo() {
        binding.ivBack.setOnClickListener { findNavController().popBackStack() }
        item = arguments?.get("item") as Banners
        if (item.attachmentType.equals("video")) {
            binding.imageview.hide()
            binding.videoview.show()
//            val uri: Uri = Uri.parse(item.image)
//            binding.videoview.setVideoURI(uri)
//            binding.videoview.start()
//            binding.videoview.requestFocus()
//            binding.videoview.setOnPreparedListener { mp ->
//                mp.setLooping(true)
//            }
//            binding.videoview.setZOrderOnTop(true)
//            binding.videoview.setBackgroundColor(Color.TRANSPARENT);
//


            item.image?.let { initializePlayer(it) }
        } else {
            binding.imageview.show()
            binding.videoview.hide()
            Glide.with(requireActivity()).load(item.image).placeholder(R.drawable.ic_x)
                .into(binding.imageview)
        }


    }

    lateinit var videoPlayer :ExoPlayer
    private fun initializePlayer(url:String) {
        Log.e( "initializePlayer: ", "inplayer --$url")

        binding.videoView.resizeMode = AspectRatioFrameLayout.RESIZE_MODE_ZOOM

        videoPlayer = ExoPlayer.Builder(requireActivity()).build()
        videoPlayer?.repeatMode = Player.REPEAT_MODE_ALL
        binding.videoView.player = videoPlayer

        val dataSourceFactory: DataSource.Factory = DefaultDataSourceFactory(
            requireActivity(),
            Util.getUserAgent(requireActivity(), "My X")
        )
        val videoPreview = MediaItem.fromUri(url)
        videoPreview.let {
            val videoSource: MediaSource =
                ProgressiveMediaSource.Factory(dataSourceFactory).createMediaSource(it)
            videoPlayer?.setMediaSource(videoSource)
            videoPlayer?.prepare()
            videoPlayer?.playWhenReady = true
        }
    }


    private fun releasePlayer() {
        if(videoPlayer != null) {
            videoPlayer?.release()
        }
    }

     override fun onPause() {
        super.onPause()
            releasePlayer()

    }


     override fun onStop() {
        super.onStop()
            releasePlayer()

    }
}