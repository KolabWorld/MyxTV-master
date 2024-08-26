package com.wxrk

import android.os.Bundle
import android.view.Gravity
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.navigation.NavController
import androidx.navigation.NavDestination
import androidx.navigation.fragment.findNavController
import androidx.transition.Slide
import androidx.transition.Transition
import androidx.transition.TransitionManager
import androidx.transition.TransitionSet
import com.wxrk.databinding.ActivityMaindashboardBinding

class MainActivity : BaseActivity() {
    lateinit var binding: ActivityMaindashboardBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMaindashboardBinding.inflate(layoutInflater)
        setContentView(binding.root)

        initview()
    }

    private fun initview() {
        val navHost = supportFragmentManager.findFragmentById(R.id.main_nav_host_fragment)!!
        val navController = navHost.findNavController()


        binding.rlHome.setOnClickListener {
            navController.navigate(
                R.id.home_fragment
            )
        }
        binding.rlEvent.setOnClickListener {
            navController.navigate(
                R.id.event_fragment
            )


        }
        binding.rlOffer.setOnClickListener {
            navController.navigate(
                R.id.offer_fragment
            )
        }
        binding.rlTwitch.setOnClickListener {
            navController.navigate(
                R.id.twitch_fragment
            )
        }


        navController.addOnDestinationChangedListener(object :
            NavController.OnDestinationChangedListener {
            override fun onDestinationChanged(
                controller: NavController,
                destination: NavDestination,
                arguments: Bundle?
            ) {
                when (destination.id) {
                    R.id.home_fragment -> {
                        binding.ivHome.setImageResource(R.drawable.ic_home_click)
                        binding.ivShop.setImageResource(R.drawable.ic_cart_unclick)
                        binding.ivTicket.setImageResource(R.drawable.ic_ticket_unclick)
                        binding.ivTwitch.setImageResource(R.drawable.ic_twitch_unselected)

                        binding.viewHome.show()
                        binding.viewShop.hide()
                        binding.viewTicket.hide()
                        binding.viewLevel.hide()
                        slideTopBottomVisibility(binding.llBottomnav, true)

                    }
                    R.id.offer_fragment -> {
                        binding.ivHome.setImageResource(R.drawable.ic_home_grey)
                        binding.ivShop.setImageResource(R.drawable.ic_cart_blue)
                        binding.ivTicket.setImageResource(R.drawable.ic_ticket_unclick)
                        binding.ivTwitch.setImageResource(R.drawable.ic_twitch_unselected)

                        binding.viewHome.hide()
                        binding.viewShop.show()
                        binding.viewTicket.hide()
                        binding.viewLevel.hide()
                        slideTopBottomVisibility(binding.llBottomnav, true)

                    }
                    R.id.event_fragment -> {
                        binding.ivHome.setImageResource(R.drawable.ic_home_grey)
                        binding.ivShop.setImageResource(R.drawable.ic_cart_unclick)
                        binding.ivTicket.setImageResource(R.drawable.ic_ticket_blue)
                        binding.ivTwitch.setImageResource(R.drawable.ic_twitch_unselected)
                        binding.viewHome.hide()
                        binding.viewShop.hide()
                        binding.viewTicket.show()
                        binding.viewLevel.hide()
                        slideTopBottomVisibility(binding.llBottomnav, true)

                    }
//                    R.id.twitch_fragment -> {
//                        binding.ivHome.setImageResource(R.drawable.ic_home_grey)
//                        binding.ivShop.setImageResource(R.drawable.ic_cart_unclick)
//                        binding.ivTicket.setImageResource(R.drawable.ic_ticket_blue)
//                        binding.ivTwitch.setImageResource(R.drawable.ic_twitch_unselected)
//                        binding.viewHome.hide()
//                        binding.viewShop.hide()
//                        binding.viewTicket.show()
//                        binding.viewLevel.hide()
//                        slideTopBottomVisibility(binding.llBottomnav, true)
//
//                    }
                    R.id.twitch_fragment -> {
                        binding.ivHome.setImageResource(R.drawable.ic_home_grey)
                        binding.ivShop.setImageResource(R.drawable.ic_cart_unclick)
                        binding.ivTicket.setImageResource(R.drawable.ic_ticket_unclick)
                        binding.ivTwitch.setImageResource(R.drawable.ic_twitch_selected)

                        binding.viewHome.hide()
                        binding.viewShop.hide()
                        binding.viewTicket.hide()
                        binding.viewLevel.show()
                        slideTopBottomVisibility(binding.llBottomnav, true)

                    }

                    R.id.eventdetail_fragment -> {
//                    binding.llBottomnav.hide()
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }
                    R.id.sponserads_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }
                    R.id.twitchdetail_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }

                    R.id.offer_detailfragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }

                    R.id.profile_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }
                    R.id.weekreport_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }
                    R.id.wallet_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }
                    R.id.promocode_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }
                    R.id.editprofile_fragment -> {
                        slideTopBottomVisibility(binding.llBottomnav, false)
                    }

                }
            }

        })

    }


    var previousTime: Long = 0
    override fun onBackPressed() {
        previousTime = System.currentTimeMillis()
        if (2000 + previousTime > (previousTime)) {
            super.onBackPressed();
        } else {
            Toast.makeText(getBaseContext(), "Tap back button in order to exit", Toast.LENGTH_SHORT)
                .show()
        }
    }


    fun slideTopBottomVisibility(bottomLayout: View, show: Boolean) {


        val bottomTransition: Transition = Slide(Gravity.BOTTOM)
        bottomTransition.duration = 600
        bottomTransition.addTarget(bottomLayout)

        val transitionSet = TransitionSet()
        transitionSet.addTransition(bottomTransition)

        TransitionManager.beginDelayedTransition(bottomLayout.parent as ViewGroup, transitionSet)
        bottomLayout.visibility = if (show) View.VISIBLE else View.GONE
    }
}



