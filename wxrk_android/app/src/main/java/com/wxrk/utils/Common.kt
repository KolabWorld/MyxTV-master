package com.wxrk.utils

import android.content.Context
import android.net.Uri
import android.provider.DocumentsContract
import android.provider.MediaStore
import android.text.format.DateFormat
import android.util.Log
import android.widget.Toast
import java.io.File
import java.text.DecimalFormat
import java.text.SimpleDateFormat
import java.util.*
import java.util.regex.Matcher
import java.util.regex.Pattern

class Common {


    companion object {

        val bloctoid = ""
        fun validMail(yourEmailString: String): Boolean {
            val emailPattern: Pattern = Pattern.compile(".+@.+\\.[a-z]+")
            val emailMatcher: Matcher = emailPattern.matcher(yourEmailString)
            return emailMatcher.matches()
        }

        fun logUnlimited(tag: String, string: String) {
            val maxLogSize = 1000
            string.chunked(maxLogSize).forEach { Log.v(tag, it) }
        }

        fun tooast(tag: Context, string: String) {

            Toast.makeText(tag, string, Toast.LENGTH_LONG).show()
        }

//        fun convertEventdate(formate:String,myDate:String) :String{
//            val sdf = SimpleDateFormat(formate)
//            val date: Date = sdf.parse(myDate)
//            return date.toString()
//        }


        fun convertEventdate(formate: String, myDate: String): String {
            val f = SimpleDateFormat("yyyy-MM-dd HH:mm:ss")
            val d =
                f.parse(myDate) // Format String to a dateobject with the format provided by the String.
            val f2 = SimpleDateFormat(formate) // MMMM for full month name
            println(f2.format(d)) // Use the second format to create the desired format as String with d as input.
            return f2.format(d)
        }

        fun converdate(myDate: String): Calendar {
            val formatter = SimpleDateFormat("yyyy-MM-dd HH:mm:ss")
            val date_str = formatter.parse(myDate)
            val cal = Calendar.getInstance()
            cal.time = date_str
            return cal
        }

        fun date_diffrance(startdate: Calendar): String {
            var diff = System.currentTimeMillis() - startdate.timeInMillis
            // Calculate difference in seconds
            // Calculate difference in seconds
            val diffSeconds = diff / 1000

            // Calculate difference in minutes

            // Calculate difference in minutes
            val diffMinutes = diff / (60 * 1000)

            // Calculate difference in hours

            // Calculate difference in hours
            val diffHours = diff / (60 * 60 * 1000)

            // Calculate difference in days

            // Calculate difference in days
            val diffDays = diff / (24 * 60 * 60 * 1000)

            return "${diffDays}d : ${diffHours}h : ${diffMinutes}m : ${diffSeconds}s left"
        }


        fun getFileFromUri(context: Context, uri: Uri?): File? {
            uri ?: return null
            uri.path ?: return null

            var newUriString = uri.toString()
            newUriString = newUriString.replace(
                "content://com.android.providers.downloads.documents/",
                "content://com.android.providers.media.documents/"
            )
            newUriString = newUriString.replace(
                "/msf%3A", "/image%3A"
            )
            val newUri = Uri.parse(newUriString)

            var realPath = String()
            val databaseUri: Uri
            val selection: String?
            val selectionArgs: Array<String>?
            if (newUri.path?.contains("/document/image:") == true) {
                databaseUri = MediaStore.Images.Media.EXTERNAL_CONTENT_URI
                selection = "_id=?"
                selectionArgs = arrayOf(DocumentsContract.getDocumentId(newUri).split(":")[1])
            } else {
                databaseUri = newUri
                selection = null
                selectionArgs = null
            }
            try {
                val column = "_data"
                val projection = arrayOf(column)
                val cursor = context.contentResolver.query(
                    databaseUri,
                    projection,
                    selection,
                    selectionArgs,
                    null
                )
                cursor?.let {
                    if (it.moveToFirst()) {
                        val columnIndex = cursor.getColumnIndexOrThrow(column)
                        realPath = cursor.getString(columnIndex)
                    }
                    cursor.close()
                }
            } catch (e: Exception) {
                Log.i("GetFileUri Exception:", e.message ?: "")
            }
            val path = realPath.ifEmpty {
                when {
                    newUri.path?.contains("/document/raw:") == true -> newUri.path?.replace(
                        "/document/raw:",
                        ""
                    )
                    newUri.path?.contains("/document/primary:") == true -> newUri.path?.replace(
                        "/document/primary:",
                        "/storage/emulated/0/"
                    )
                    else -> return null
                }
            }
            return if (path.isNullOrEmpty()) null else File(path)
        }

        fun getDate(timestamp: Long): String {
            val calendar = Calendar.getInstance(Locale.ENGLISH)
            calendar.timeInMillis = timestamp
            val date = DateFormat.format("yyyy-MM-dd", calendar).toString()
            return date
        }

        fun getlastsynch(timestamp: Long): String {
            val calendar = Calendar.getInstance(Locale.ENGLISH)
            calendar.timeInMillis = timestamp
            val date = DateFormat.format("hh:mm aa", calendar).toString()
            return date
        }

        fun countviews(count: Long): String {
            val array = arrayOf(' ', 'k', 'M', 'B', 'T', 'P', 'E')
            val value = Math.floor(Math.log10(count.toDouble())).toInt()
            val base = value / 3
            if (value >= 3 && base < array.size) {
                return DecimalFormat("#0.0").format(
                    count / Math.pow(
                        10.0,
                        (base * 3).toDouble()
                    )
                ) + array[base]
            } else {
                return DecimalFormat("#,##0").format(count)
            }
        }

    }
}